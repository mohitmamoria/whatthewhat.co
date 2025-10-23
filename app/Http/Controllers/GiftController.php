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
