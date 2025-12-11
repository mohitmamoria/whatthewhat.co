<?php

namespace App\Http\Controllers;

use App\Actions\RecordMessageExchange;
use App\Actions\SendMessageOnWhatsapp;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use App\Models\Gamification\ActivityType;
use App\Models\Message;
use App\Models\Player;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

        if (data_get($value, 'messages')) {
            return $this->handleMessages($value);
        }

        if (data_get($value, 'statuses')) {
            return $this->handleStatuses($value);
        }
    }

    public function forceSend(Request $request)
    {
        $name = data_get($request->input(), 'from_name', 'Player');
        $number = data_get($request->input(), 'from', '919716313713');
        $body = data_get($request->input(), 'body', 'QOTD');
        Log::info('WEBHOOK_PAYLOAD', [$name, $number, $body]);
        $this->sendRequiredInfo($name, $number, $body, Str::random(11));


        return 'OK';
    }

    public function test()
    {
        $value = json_decode('
{
  "messaging_product": "whatsapp",
  "metadata": {
    "display_phone_number": "918595361136",
    "phone_number_id": "311137638760111"
  },
  "statuses": [
    {
      "id": "wamid.HBgMOTE5NzE2MzEzNzEzFQIAERgSN0Y0QjAwRDNEQUMyQzI3NDRCAA==",
      "status": "failed",
      "timestamp": "1759868660",
      "recipient_id": "919167766189",
      "errors": [
        {
          "code": 131049,
          "title": "This message was not delivered to maintain healthy ecosystem engagement.",
          "message": "This message was not delivered to maintain healthy ecosystem engagement.",
          "error_data": {
            "details": "In order to maintain a healthy ecosystem engagement, the message failed to be delivered."
          }
        }
      ]
    }
  ]
}
', true);

        if (data_get($value, 'messages')) {
            dd('message');
        }

        if (data_get($value, 'statuses')) {
            return $this->handleStatuses($value);
        }
    }

    protected function handleMessages(array $value)
    {
        $name = data_get($value, 'contacts.0.profile.name', 'Curious Cat');
        $number = data_get($value, 'messages.0.from');
        $messageId = data_get($value, 'messages.0.id');
        $body = data_get($value, 'messages.0.text.body');
        if (is_null($body)) {
            $body = data_get($value, 'messages.0.button.text');
        }

        Log::info('WEBHOOK_PAYLOAD', [$name, $messageId, $number, $body]);
        $this->sendRequiredInfo($name, $number, $body, $messageId);
        return 'OK';
    }

    protected function handleStatuses(array $value)
    {
        $messageId = data_get($value, 'statuses.0.id');
        $platformStatus = data_get($value, 'statuses.0.status');

        // Only handling these status updates
        if (!in_array($platformStatus, ['delivered', 'read', 'failed'])) {
            return 'OK';
        }

        $toUpdate = [
            'status' => match ($platformStatus) {
                'delivered' => MessageStatus::DELIVERED,
                'read' => MessageStatus::READ,
                'failed' => MessageStatus::FAILED,
            }
        ];

        if ($toUpdate['status'] === MessageStatus::FAILED) {
            $toUpdate['body->errors'] = data_get($value, 'statuses.0.errors.0');
        };

        Message::query()
            ->where('platform', MessagePlatform::WHATSAPP)
            ->where('platform_message_id', $messageId)
            ->update($toUpdate);

        Log::info('WEBHOOK_PAYLOAD_STATUS', [$messageId, $toUpdate]);

        return 'OK';
    }

    private function sendRequiredInfo($name, $number, $body, $messageId)
    {
        if (is_null($number)) {
            return;
        }

        if (is_null($name)) {
            $name = 'Curious Cat';
        }

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

        // When sending downloadable
        if ($body->startsWith('GET PREORDER LINK')) {
            $url = route('shop.buy', ['ref' => $player->referrer_code]);
            $message = sprintf("Here's your unique link to pre-order What The What?! 👇 \n\n%s", $url);

            (new SendMessageOnWhatsapp)($player, $message);

            return;
        }

        // When sending waitlist status
        if ($body->startsWith('Check Status')) {
            Artisan::call('app:invite-to-preorder', ['phone' => $player->number, 'count' => 1]);

            return;
        }

        // QOTD (regular command)
        // QOTD [MOMO3713] (referral command)
        if ($body->startsWith('QOTD')) {
            $ref = null;
            if ($body->containsAll(['[', ']'])) {
                $ref = $body->between('[', ']')->toString();
            }

            $url = $player->directLoginUrlTo(route('qotd.index', ['ref' => $ref]));
            $message = "Today's QOTD (Question Of The Day) is ready to play.\n\nPlay now, earn points, and maintain your streak.👇";

            (new SendMessageOnWhatsapp)($player, Message::INTERACTIVE_PREFIX . $message, [
                'type' => 'cta_url',
                'action' => [
                    'name' => 'cta_url',
                    'parameters' => [
                        'display_text' => "Answer today's QOTD",
                        'url' => $url,
                    ]
                ]
            ]);

            return;
        }

        // QOTD (regular command)
        // QOTD [MOMO3713] (referral command)
        if ($body->startsWith('REMIND ME')) {
            $ref = null;
            if ($body->containsAll(['[', ']'])) {
                $ref = $body->between('[', ']')->toString();
            }

            $url = $player->directLoginUrlTo(route('qotd.index', ['ref' => $ref]));
            $message = "Today's QOTD (Question Of The Day) is ready to play.\n\nPlay now, earn points, and maintain your streak.👇";

            (new SendMessageOnWhatsapp)($player, Message::INTERACTIVE_PREFIX . $message, [
                'type' => 'cta_url',
                'action' => [
                    'name' => 'cta_url',
                    'parameters' => [
                        'display_text' => "Answer today's QOTD",
                        'url' => $url,
                    ]
                ]
            ]);

            return;
        }
    }
}
