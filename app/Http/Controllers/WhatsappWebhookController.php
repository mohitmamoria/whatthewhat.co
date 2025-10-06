<?php

namespace App\Http\Controllers;

use App\Actions\RecordMessageExchange;
use App\Actions\SendMessageOnWhatsapp;
use App\Enums\MessagePlatform;
use App\Models\Gamification\ActivityType;
use App\Models\Message;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsappWebhookController extends Controller
{
    public function verify(Request $request)
    {
        Log::info('WEBHOOK_VERIFICATION_PAYLOAD', $request->toArray());

        if ($request->input('hub_verify_token') === config('services.whatsapp.verification_token')) {
            return $request->input('hub_challenge');
        }

        return 'OK';
    }

    public function handle(Request $request)
    {
        $input = $request->input();

        $value = data_get($input, 'entry.0.changes.0.value');

        $name = data_get($value, 'contacts.0.profile.name');
        $number = data_get($value, 'messages.0.from');
        $messageId = data_get($value, 'messages.0.id');
        $body = data_get($value, 'messages.0.text.body');

        Log::info('WEBHOOK_PAYLOAD', [$name, $messageId, $number, $body]);

        $this->sendRequiredInfo($name, $number, $body, $messageId);


        return 'OK';
    }

    public function forceSend(Request $request)
    {
        $name = data_get($request->input(), 'from_name', 'Player');
        $number = data_get($request->input(), 'from', '919716313713');
        $body = data_get($request->input(), 'body', 'WTW Bonus Pages');
        Log::info('WEBHOOK_PAYLOAD', [$name, $number, $body]);
        $this->sendRequiredInfo($name, $number, $body, Str::random(11));


        return 'OK';
    }

    private function sendRequiredInfo($name, $number, $body, $messageId)
    {
        $body = str($body);
        $player = Player::sync($name, $number);

        if ($body->length() > 0) {
            (new RecordMessageExchange)->incoming(
                $player,
                MessagePlatform::WHATSAPP,
                $messageId,
                [
                    'content' => $body,
                ]
            );
        }

        // When sending downloadable
        if ($body->startsWith('WTW Bonus Pages')) {
            $player->acted(ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
            (new SendMessageOnWhatsapp)($player, Message::TEMPLATE_PREFIX . 'wtw_bonus', [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $name,
                        ],
                    ],
                ],
                [
                    "type" => "button",
                    "sub_type" => "url",
                    "index" => 0,
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => 'wtw-bonus', // this will be applied after aph.to/<here> by Meta
                        ],
                    ],
                ],
            ]);

            // Log::info('WEBHOOK_RESPONSE', [$response->body()]);
            return;
        }
    }
}
