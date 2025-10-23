<?php

namespace App\Actions\Auth;

use App\Actions\SendMessageOnWhatsapp;
use App\Models\Message;
use App\Models\Player;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class VerifyOtp
{
    public function __invoke(Player $player, string $attempt): bool
    {
        $otp = $player->otps()->unused()->unexpired()->latest()->first();

        if (is_null($otp) || !Hash::check($attempt, $otp->code)) {
            return false;
        }

        $otp->markAsUsed();

        return true;
    }
}
