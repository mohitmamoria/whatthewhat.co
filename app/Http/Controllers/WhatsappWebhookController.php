<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Player;
use App\Models\Qr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $body = data_get($value, 'messages.0.text.body');

        Log::info('WEBHOOK_PAYLOAD', [$name, $number, $body]);
        $this->sendRequiredInfo($name, $number, $body);


        return 'OK';
    }

    public function forceSend(Request $request)
    {
        $name = data_get($request->input(), 'from_name', 'Player');
        $number = data_get($request->input(), 'from', '919716313713');
        $body = data_get($request->input(), 'body', 'WTW Bonus Pages');
        Log::info('WEBHOOK_PAYLOAD', [$name, $number, $body]);
        $this->sendRequiredInfo($name, $number, $body);


        return 'OK';
    }

    private function sendRequiredInfo($name, $number, $body)
    {
        $body = str($body);

        // When sending downloadable
        if ($body->startsWith('WTW Bonus Pages')) {
            Player::sync($name, $number);
            $response = Http::baseUrl('https://graph.facebook.com/v20.0/311137638760111')
                ->withToken(config('services.whatsapp.access_token'))
                ->acceptJson()
                ->post('messages', [
                    "messaging_product" => "whatsapp",
                    "to" => $number,
                    "type" => "template",
                    "template" => [
                        "name" => "wtw_bonus",
                        "language" => [
                            "code" => "en",
                        ],
                        "components" => [
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
                        ],
                    ],
                ]);

            Log::info('WEBHOOK_RESPONSE', [$response->body()]);
            return;
        }
    }
}
