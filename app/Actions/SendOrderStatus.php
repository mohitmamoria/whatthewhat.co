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
        $attributes = data_get($order, 'customAttributes');
        $ref = data_get(collect($attributes)->where('key', 'ref')->first(), 'value');
        $referrer = Player::where('referrer_code', $ref)->first();

        $buyerPhone = data_get($order, 'billingAddress.phone');

        $player = Player::where('number', normalize_phone($buyerPhone))->first();

        return [$referrer->number ?? null, $player->number ?? null];
    }
}
