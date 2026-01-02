<?php

namespace App\Services\Whatsapp;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Whatsapp
{
    protected $baseUrl = 'https://graph.facebook.com/v20.0/311137638760111';

    protected $token;

    public function __construct()
    {
        $this->token = config('services.whatsapp.access_token');
    }

    public static function sendTemplate(string $number, string $template, $components = []): Response
    {
        return (new static)->client()->post('messages', [
            "messaging_product" => "whatsapp",
            "to" => $number,
            "type" => "template",
            "template" => [
                "name" => $template,
                "language" => [
                    "code" => "en",
                ],
                "components" => $components,
            ],
        ]);
    }

    public static function sendInteractive(string $number, array $interactive): Response
    {
        return (new static)->client()->post('messages', [
            "messaging_product" => "whatsapp",
            "to" => $number,
            "type" => "interactive",
            "interactive" => $interactive,
        ]);
    }

    public static function sendText(string $number, string $message): Response
    {
        return (new static)->client()->post('messages', [
            "messaging_product" => "whatsapp",
            "to" => $number,
            "type" => "text",
            "text" => [
                "preview_url" => true,
                "body" => $message,
            ]
        ]);
    }

    protected function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->token)
            ->acceptJson();
    }
}
