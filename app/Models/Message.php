<?php

namespace App\Models;

use App\Enums\MessageDirection;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use App\ValueObjects\MessageBody;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const TEMPLATE_PREFIX = '__t:';

    protected $fillable = [
        'platform',
        'platform_message_id',
        'body',
        'direction',
        'status',
    ];

    protected function casts()
    {
        return [
            'platform' => MessagePlatform::class,
            'body' => 'array',
            'direction' => MessageDirection::class,
            'status' => MessageStatus::class,
        ];
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
