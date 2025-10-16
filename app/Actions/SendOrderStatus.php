<?php

namespace App\Actions;

use App\Models\Player;
use Illuminate\Support\Carbon;

class SendOrderStatus
{
    protected array $skuToProduct = [
        'wtw-book-solo' => 'What The What?! (Curious)',
        'wtw-book-calendar' => 'What The What?! (Curiouser)',
        'wtw-book-calendar-duo' => 'What The What?! (Curiouser and Curiouser)',
    ];

    public function __invoke(array $order)
    {
        // Finding the referrer
        $attributes = data_get($order, 'customAttributes');
        $ref = data_get(collect($attributes)->where('key', 'ref')->first(), 'value');
        if (is_null($ref)) {
            return;
        }

        $referrer = Player::byReferrerCode($ref);
        if (is_null($referrer)) {
            return;
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

            $referrer->acted($activity, [
                'order_id' => data_get($order, 'id'),
                'order_name' => data_get($order, 'name'),
                'sku' => $sku,
                'quantity' => $quantity,
            ], Carbon::parse(data_get($order, 'processedAt')));
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
