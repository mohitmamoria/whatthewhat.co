<?php

namespace App\Actions;

use App\Enums\ReferralType;
use App\Models\Gamification\ActivityType;
use App\Models\GiftCode;
use App\Models\Player;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecordShopifyOrderForPlayer
{
    public function __invoke(array $order)
    {
        DB::transaction(function () use ($order) {
            $buyer = $this->identifyBuyer($order);
            $this->recordPurchasedActivity($buyer, $order);
            $this->makeGiftCodesUsed($order);
        });
    }

    protected function recordPurchasedActivity(Player $buyer, array $order)
    {
        [$referrer, $referralType] = $this->identifyReferral($order);

        // Processing line items
        $lines = data_get($order, 'lineItems.edges', []);
        foreach ($lines as $line) {
            $sku = data_get($line, 'node.sku');
            $activity = $this->identifyActivity($sku);
            if (is_null($activity)) {
                continue;
            }

            $quantity = data_get($line, 'node.quantity', 0);
            if ($quantity <= 0) {
                continue;
            }

            // Common meta for activities recorded below
            $meta = [
                'order_id' => data_get($order, 'id'),
                'order_name' => data_get($order, 'name'),
                'sku' => $sku,
                'quantity' => $quantity,
            ];

            // Record referral activity, if applicable
            if ($referrer) {
                $referrer->acted(ActivityType::WTW_REFERRED, [
                    ...$meta,
                    'type' => $referralType,
                ], Carbon::parse(data_get($order, 'processedAt')));
            }

            // Record purchase activity for buyer
            $activity = $buyer->acted($activity, [
                ...$meta,
                'ref' => $referrer?->referrer_code,
                'ref_type' => $referralType,
            ], Carbon::parse(data_get($order, 'processedAt')));
        }
    }

    protected function makeGiftCodesUsed(array $order)
    {
        $attributes = data_get($order, 'customAttributes');
        $giftCodeName = data_get(collect($attributes)->where('key', 'giftcode')->first(), 'value');
        $receiverName = data_get(collect($attributes)->where('key', 'receiver')->first(), 'value');

        if ($giftCodeName) {
            $receiver = Player::byReferrerCode($receiverName);
            $giftCode = GiftCode::unreceived()->where('name', $giftCodeName)->first();
            if ($giftCode) {
                $giftCode->receiver()->associate($receiver);
                $giftCode->received_at = now();
                $giftCode->save();
            }
        }
    }

    protected function identifyReferral(array $order): array
    {
        $attributes = data_get($order, 'customAttributes');
        $ref = data_get(collect($attributes)->where('key', 'ref')->first(), 'value');
        $referrer = $ref ? Player::where('referrer_code', $ref)->first() : null;

        if (is_null($referrer)) {
            return [null, ReferralType::NONE];
        }

        $buyerPhones = collect([
            data_get($order, 'billingAddress.phone'),
            data_get($order, 'shippingAddress.phone'),
            data_get($order, 'customer.defaultAddress.phone'),
        ])
            ->filter()->map(fn($p) => phone_e164($p))
            ->filter()->map(fn($p) => normalize_phone($p));

        if ($buyerPhones->contains($referrer->number)) {
            return [$referrer, ReferralType::SELF];
        }

        return [$referrer, ReferralType::OTHER];
    }

    protected function identifyBuyer(array $order)
    {
        $phone = collect([
            data_get($order, 'shippingAddress.phone'),
            data_get($order, 'billingAddress.phone'),
            data_get($order, 'customer.defaultAddress.phone'),
        ])
            ->filter()->map(fn($p) => phone_e164($p))
            ->filter()->map(fn($p) => normalize_phone($p))
            ->first();

        $buyer = Player::where('number', $phone)->first();
        if (is_null($buyer)) {
            $buyer = Player::sync(
                name: data_get($order, 'customer.displayName'),
                number: $phone,
            );
        }

        return $buyer;
    }

    protected function identifyActivity(string $sku)
    {
        if (str($sku)->startsWith('wtw-book-')) {
            return ActivityType::WTW_PURCHASED;
        }

        if (str($sku)->startsWith('gift-wtw-book-')) {
            return ActivityType::WTW_GIFTED;
        }
    }
}
