<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QotdGame extends Model
{
    use SoftDeletes;

    const DEFAULT_EXPIRES_DAYS = 21;
    const EXTENSION_EXPIRES_DAYS = 7;

    protected $fillable = [
        'player_id',
        'referrer_id',
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

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'referrer_id');
    }

    public function longestStreakStartAttempt()
    {
        return $this->belongsTo(Attempt::class, 'longest_streak_start_attempt_id');
    }

    public function currentStreakStartAttempt()
    {
        return $this->belongsTo(Attempt::class, 'current_streak_start_attempt_id');
    }

    protected function isExpired(): Attribute
    {
        // NULL expires_on means never expires
        return Attribute::make(
            get: fn() => $this->expires_on === null ? false : $this->expires_on->isPast(),
        );
    }

    public function recalculateExpiry(): void
    {
        $count = $this->player->referredQotds()->count();

        if ($count === 0) {
            return;
        }

        if ($count >= 10) {
            $this->update([
                'expires_on' => null,
            ]);
            return;
        }

        $daysToAdd = self::DEFAULT_EXPIRES_DAYS + ($count * self::EXTENSION_EXPIRES_DAYS);
        $this->update([
            'expires_on' => $this->joined_on->addDays($daysToAdd),
        ]);
    }
}
