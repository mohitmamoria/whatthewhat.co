<?php

namespace App\Actions;

use App\Actions\RecordMessageExchange;
use App\Enums\MessageDirection;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use App\Models\Message;
use App\Models\Player;
use App\Services\Whatsapp\Whatsapp;
use App\ValueObjects\MessageBody;
use Illuminate\Http\Client\Response;

class SendMessageOnWhatsapp
{
    public function __invoke(Player $player, string $message, array $components = []): Message
    {
        if (str_starts_with($message, Message::TEMPLATE_PREFIX)) {
            $template = substr($message, strlen(Message::TEMPLATE_PREFIX));
            $response = (new Whatsapp)->sendTemplate($player->number, $template, $components);
            return $this->recordMessage($response, $player, $message, $components);
        }

        $response = (new Whatsapp)->sendText($player->number, $message);
        return $this->recordMessage($response, $player, $message, $components);
    }

    protected function recordMessage(Response $response, Player $player, string $message, array $components = []): ?Message
    {
        if (! data_get($response->json(), 'messages.0.id')) {
            return null;
        }
        return (new RecordMessageExchange)->outgoing(
            $player,
            MessagePlatform::WHATSAPP,
            data_get($response->json(), 'messages.0.id'),
            [
                'content' => $message,
                'components' => $components,
            ]
        );
    }
}
