<?php

namespace App\Actions\Gifting;

use App\Models\Gamification\Activity;
use App\Models\Gift;

class CreateGift
{
    protected array $skuToValue = [
        'gift-wtw-book-solo-with-shipping' => 479,
        'gift-wtw-book-solo-without-shipping' => 399,
    ];

    public function __invoke(Activity $activity): Gift
    {
        $existing = $this->findExistingGift($activity);
        if ($existing) {
            return $existing;
        }

        $player = $activity->owner;
        $valuePerCode = $this->skuToValue[$activity->meta['sku']] ?? null;
        return $player->giftsGiven()->create([
            'shopify_order_id' => $activity->meta['order_id'],
            'value_per_code' => $valuePerCode,
            'quantity' => $activity->meta['quantity'],
        ]);
    }

    protected function findExistingGift(Activity $activity): ?Gift
    {
        return Gift::where('shopify_order_id', $activity->meta['order_id'])->first();
    }
}
