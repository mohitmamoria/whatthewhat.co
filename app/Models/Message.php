<?php

namespace App\Models;

use App\Enums\MessageDirection;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'platform',
        'platform_message_id',
        'body',
        'direction',
        'status',
    ];

    protected $casts = [
        'platform' => MessagePlatform::class,
        'body' => 'array',
        'direction' => MessageDirection::class,
        'status' => MessageStatus::class,
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
