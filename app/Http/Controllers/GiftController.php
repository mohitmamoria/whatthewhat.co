<?php

namespace App\Http\Controllers;

use App\Actions\Gifting\ReserveGiftCode;
use App\Http\Resources\GiftResource;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GiftController extends Controller
{
    public function show(Request $request, Gift $gift)
    {
        return inertia('Gifts/Show', [
            'gift' => GiftResource::make($gift),
        ]);
    }

    public function lucky(Request $request, string $code)
    {
        if ($code !== env('GIFT_LUCKY_CODE')) {
            return redirect()->route('home');
        }

        $gift = Gift::availableForAll()->whereHas('giftCodes', function ($query) {
            return $query->ready();
        })->inRandomOrder()->first();

        if (!is_null($gift)) {
            return redirect()->route('gift.show', $gift);
        }

        $gift = Gift::availableForAll()->inRandomOrder()->first();
        return redirect()->route('gift.show', $gift);
    }

    public function luckyOne(Request $request)
    {
        $gift = Gift::availableForAll()->whereHas('giftCodes', function ($query) {
            return $query->ready();
        })->inRandomOrder()->first();

        if (!is_null($gift)) {
            $giftCode = $gift->giftCodes()->ready()->first();
            return route('gift_code.show', ['gift' => $gift, 'giftCode' => $giftCode]);
        }

        return 'NONE AVAILABLE';
    }

    public function reserve(Request $request, Gift $gift)
    {
        $player = $request->user('player');
        if ($player->giftCodesReceived()->count() > 0) {
            throw ValidationException::withMessages(['gift' => 'You have already received a gift.']);
        }

        $giftCode = (new ReserveGiftCode)($gift);

        if (!$giftCode) {
            throw ValidationException::withMessages(['gift' => 'No more gifts available at the moment.']);
        }

        return redirect()->route('gift_code.show', compact('gift', 'giftCode'));
    }
}
