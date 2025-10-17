<?php

namespace App\Actions;

use App\Enums\ReferralType;
use App\Models\Gamification\ActivityType;
use App\Models\Player;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecordShopifyOrderForPlayer
{
    public function __invoke(array $order)
    {
        DB::transaction(function () use ($order) {
            [$referrer, $referralType] = $this->identifyReferral($order);
            if ($referrer) {
                $this->recordReferredActivity($order, $referrer, $referralType);
            }

            $buyer = $this->identifyBuyer($order);
            $this->recordPurchasedActivity($order, $buyer, $referrer?->referrer_code);
        });
    }


    protected function recordReferredActivity(array $order, Player $referrer, ReferralType $type = ReferralType::OTHER)
    {
        // Processing line items
        $lines = data_get($order, 'lineItems.edges', []);
        foreach ($lines as $line) {
            $sku = data_get($line, 'node.sku');
            $activity = $this->identifyActivity($sku);
            if (is_null($activity)) {
                continue;
            }

            $quantity = $this->identifyQuantities($sku, data_get($line, 'node.quantity', 0));
            if ($quantity <= 0) {
                continue;
            }

            $referrer->acted(ActivityType::WTW_REFERRED, [
                'order_id' => data_get($order, 'id'),
                'order_name' => data_get($order, 'name'),
                'sku' => $sku,
                'quantity' => $quantity,
                'type' => $type,
            ], Carbon::parse(data_get($order, 'processedAt')));
        }
    }

    protected function recordPurchasedActivity(array $order, Player $buyer, ?string $ref)
    {
        // Processing line items
        $lines = data_get($order, 'lineItems.edges', []);
        foreach ($lines as $line) {
            $sku = data_get($line, 'node.sku');
            $activity = $this->identifyActivity($sku);
            if (is_null($activity)) {
                continue;
            }

            $quantity = $this->identifyQuantities($sku, data_get($line, 'node.quantity', 0));
            if ($quantity <= 0) {
                continue;
            }

            $buyer->acted($activity, [
                'order_id' => data_get($order, 'id'),
                'order_name' => data_get($order, 'name'),
                'sku' => $sku,
                'quantity' => $quantity,
                'ref' => $ref,
            ], Carbon::parse(data_get($order, 'processedAt')));
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
        ])->filter()->map(fn($p) => normalize_phone($p));

        if ($buyerPhones->contains($referrer->number)) {
            return [$referrer, ReferralType::SELF];
        }

        return [$referrer, ReferralType::OTHER];
    }

    protected function identifyBuyer(array $order)
    {
        $phone = data_get($order, 'shippingAddress.phone');
        $buyer = Player::where('number', normalize_phone($phone))->first();
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
    }

    protected function identifyQuantities(string $sku, int $quantity)
    {
        if (str($sku)->contains('-duo')) {
            return $quantity * 2;
        }

        return $quantity;
    }
}
