<?php

namespace App\Actions;

use App\Models\Gamification\ActivityType;
use App\Models\Player;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecordShopifyOrderForPlayer
{
    protected array $skuToActivity = [
        'wtw-book-solo' => ActivityType::WTW_PURCHASED,
        'wtw-book-calendar' => ActivityType::WTW_PURCHASED,
        'wtw-book-calendar-duo' => ActivityType::WTW_PURCHASED,
    ];

    public function __invoke(array $order)
    {
        DB::transaction(function () use ($order) {
            // Finding the referrer
            $attributes = data_get($order, 'customAttributes');
            $ref = data_get(collect($attributes)->where('key', 'ref')->first(), 'value');

            $buyerPhone = data_get($order, 'billingAddress.phone');

            $player = Player::where('number', $buyerPhone)->first();
            if (is_null($player)) {
                $player = Player::sync(
                    name: data_get($order, 'customer.displayName'),
                    number: $buyerPhone,
                );
            }

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

                $player->acted($activity, [
                    'order_id' => data_get($order, 'id'),
                    'order_name' => data_get($order, 'name'),
                    'sku' => $sku,
                    'quantity' => $quantity,
                    'ref' => $ref,
                ], Carbon::parse(data_get($order, 'processedAt')));
            }
        });
    }

    protected function identifyActivity(string $sku)
    {
        return $this->skuToActivity[$sku] ?? null;
    }

    protected function identifyQuantities(string $sku, int $quantity)
    {
        if (str($sku)->contains('-duo')) {
            return $quantity * 2;
        }

        return $quantity;
    }
}
