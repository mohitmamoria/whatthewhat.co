<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function verify(Request $request)
    {
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

        $this->sendRequiredInfo($name, $number, $body);


        return 'OK';
    }

    private function sendRequiredInfo($name, $number, $body)
    {
        $body = str($body);

        // When sending downloadable
        if ($body->startsWith('Send ')) {
            $qrName = $body->chopStart('Send ');
            $qr = Qr::where('name', $qrName)->first();

            // Do nothing if no such QR exists
            if (!$qr) {
                return;
            }

            Player::sync($name, $number);
            $response = Http::baseUrl('https://graph.facebook.com/v20.0/311137638760111')
                ->withToken(config('services.whatsapp.access_token'))
                ->acceptJson()
                ->post('messages', [
                    "messaging_product" => "whatsapp",
                    "to" => $number,
                    "type" => "template",
                    "template" => [
                        "name" => "link_to_episode_quiz_questions",
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
                                        "text" => $qr->download_path,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);
            return;
        }
    }
}
