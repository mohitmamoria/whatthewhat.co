<?php

namespace App\Actions\Auth;

use App\Actions\SendMessageOnWhatsapp;
use App\Models\Message;
use App\Models\Player;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class SendOtp
{
    public function __invoke(Player $player)
    {
        // Cannot request another OTP within 1 minute of the last one
        if ($player->otps()->unused()->latest()->first()->created_at > now()->subMinute()) {
            return;
        }

        $code = $this->generate();

        $player->otps()->unused()->delete();
        $player->otps()->create([
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
        ]);

        (new SendMessageOnWhatsapp)($player, Message::TEMPLATE_PREFIX . 'otp', [
            [
                "type" => "body",
                "parameters" => [
                    [
                        "type" => "text",
                        "text" => $code,
                    ],
                ],
            ],
            [
                'type' => 'button',
                'sub_type' => 'url',
                'index' => '0',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $code,
                    ],
                ],
            ]
        ]);
    }

    protected function generate(int $digits = 6): string
    {
        return str_pad((string)random_int(0, 10 ** $digits - 1), $digits, '0', STR_PAD_LEFT);
    }
}
