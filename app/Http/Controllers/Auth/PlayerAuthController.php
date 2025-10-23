<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendOtp;
use App\Actions\Auth\VerifyOtp;
use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlayerAuthController extends Controller
{
    public function login(Request $request)
    {
        return inertia('Auth/PlayerLogin');
    }

    public function otp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = normalize_phone($validated['phone']);

        $player = Player::sync(Player::DEFAULT_NAME, $phone, shouldOverride: false);

        (new SendOtp)($player);

        return redirect()->back();
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string',
            'next' => 'sometimes|string',
        ]);

        $phone = normalize_phone($validated['phone']);

        $player = Player::sync(Player::DEFAULT_NAME, $phone, shouldOverride: false);

        $verified = (new VerifyOtp)($player, $validated['otp']);
        if (! $verified) {
            throw ValidationException::withMessages([
                'otp' => 'The provided OTP is incorrect or has expired.',
            ]);
        }

        auth('player')->login($player);

        if (! empty($validated['next'])) {
            return redirect()->intended($validated['next']);
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        auth('player')->logout();

        return redirect()->route('home');
    }
}
