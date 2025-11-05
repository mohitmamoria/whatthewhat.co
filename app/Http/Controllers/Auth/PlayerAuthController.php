<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendOtp;
use App\Actions\Auth\VerifyOtp;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Player;
use App\Services\Country\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PlayerAuthController extends Controller
{
    public function login(Request $request)
    {
        return inertia('Auth/PlayerLogin', [
            'countries' => CountryResource::collection(Country::all()),
        ]);
    }

    public function otp(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:2',
            'phone' => 'required|string',
        ]);

        try {
            $phoneUtil = PhoneNumberUtil::getInstance();

            // Parse based on the country (region) provided
            $proto = $phoneUtil->parse($validated['phone'], $validated['country']);

            // Check validity
            if (! $phoneUtil->isValidNumberForRegion($proto, $validated['country'])) {
                throw ValidationException::withMessages([
                    'phone' => 'The provided phone number is invalid for the selected country.',
                ]);
            }

            // Convert to E.164 => +919876543210
            $validated['phone'] = phone_e164($validated['phone'], $validated['country']);
        } catch (NumberParseException $e) {
            throw ValidationException::withMessages([
                'phone' => 'The provided phone number is invalid.',
            ]);
        }


        $phone = normalize_phone($validated['phone']);

        $player = Player::sync(Player::DEFAULT_NAME, $phone, shouldOverride: false);

        (new SendOtp)($player);

        return redirect()->back();
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:2',
            'phone' => 'required|string',
            'otp' => 'required|string',
            'next' => 'nullable|string',
        ]);

        try {
            $phoneUtil = PhoneNumberUtil::getInstance();

            // Parse based on the country (region) provided
            $proto = $phoneUtil->parse($validated['phone'], $validated['country']);

            // Check validity
            if (! $phoneUtil->isValidNumberForRegion($proto, $validated['country'])) {
                throw ValidationException::withMessages([
                    'phone' => 'The provided phone number is invalid for the selected country.',
                ]);
            }

            // Convert to E.164 => +919876543210
            $validated['phone'] = phone_e164($validated['phone'], $validated['country']);
        } catch (NumberParseException $e) {
            throw ValidationException::withMessages([
                'phone' => 'The provided phone number is invalid.',
            ]);
        }

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
