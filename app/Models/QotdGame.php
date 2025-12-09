<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QotdGame extends Model
{
    use SoftDeletes;

    const DEFAULT_EXPIRES_DAYS = 21;

    protected $fillable = [
        'player_id',
        'joined_on',
        'expires_on',
        'longest_streak',
        'current_streak',
        'total_attempted',
        'total_answered',
        'answered_percent',
        'average_time_taken',
    ];

    protected $casts = [
        'joined_on' => 'date',
        'expires_on' => 'date',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
