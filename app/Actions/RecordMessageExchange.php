<?php

namespace App\Actions;

use App\Enums\MessageDirection;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use App\Models\Message;
use App\Models\Player;

class RecordMessageExchange
{
    public function outgoing(Player $player, MessagePlatform $platform, string $platformMessageId, array $body): Message
    {
        return $player->messages()->create([
            'platform' => $platform,
            'platform_message_id' => $platformMessageId,
            'body' => $body,
            'direction' => MessageDirection::OUTGOING,
            'status' => MessageStatus::SENT,
        ]);
    }

    public function incoming(Player $player, MessagePlatform $platform, string $platformMessageId, array $body): Message
    {
        return $player->messages()->create([
            'platform' => $platform,
            'platform_message_id' => $platformMessageId,
            'body' => $body,
            'direction' => MessageDirection::INCOMING,
            'status' => MessageStatus::RECEIVED,
        ]);
    }
}
