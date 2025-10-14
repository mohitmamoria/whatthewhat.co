<?php

namespace App\Actions;

use App\Models\Gamification\ActivityType;
use App\Models\Player;
use Illuminate\Support\Carbon;

class RecordShopifyOrderForPlayer
{
    protected array $skuToActivity = [
        'wtw-book-solo' => ActivityType::WTW_PURCHASED,
        'wtw-book-calendar' => ActivityType::WTW_PURCHASED,
        'wtw-book-calendar-duo' => ActivityType::WTW_PURCHASED,
    ];

    public function __invoke(array $order)
    {
        // Finding the referrer
        $attributes = data_get($order, 'order.customAttributes');
        $ref = collect($attributes)->where('key', 'ref')->first()['value'];
        $referrer = Player::byReferrerCode($ref);

        if (is_null($referrer)) {
            return;
        }

        // Processing line items
        $lines = data_get($order, 'order.lineItems.edges', []);
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

            $referrer->acted($activity, [
                'order_id' => data_get($order, 'order.id'),
                'sku' => $sku,
                'quantity' => $quantity,
            ], Carbon::parse(data_get($order, 'order.processedAt')));
        }
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
