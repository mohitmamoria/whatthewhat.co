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

    public static function send($number, $template, $components = []): Response
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

    protected function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->token)
            ->acceptJson();
    }
}
