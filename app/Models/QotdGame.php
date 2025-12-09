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
        'longest_streak_start_attempt_id',
        'current_streak',
        'current_streak_start_attempt_id',
        'total_attempted',
        'total_answered',
        'answered_percent',
        'average_time_taken',
        'last_streak_calculated_at',
    ];

    protected $casts = [
        'joined_on' => 'date',
        'expires_on' => 'date',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function longestStreakStartAttempt()
    {
        return $this->belongsTo(Attempt::class, 'longest_streak_start_attempt_id');
    }

    public function currentStreakStartAttempt()
    {
        return $this->belongsTo(Attempt::class, 'current_streak_start_attempt_id');
    }
}
