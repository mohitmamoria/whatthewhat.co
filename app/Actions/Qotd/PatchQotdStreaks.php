<?php

namespace App\Actions\Qotd;

use App\Models\Attempt;
use App\Models\Player;
use Illuminate\Support\Carbon;

class PatchQotdStreaks
{
    const TIMEZONE = 'Asia/Kolkata';

    public function __invoke(Player $player, Attempt $attempt): void
    {
        $qotd = $player->qotd;

        $from = $qotd->last_streak_calculated_at;

        $attempts = $player->attempts()
            ->where('created_at', '>', $from)
            ->orderBy('created_at', 'asc')
            ->get();

        $lastCalculatedAttempt = $player->attempts()
            ->where('created_at', '<=', $from)
            ->orderBy('created_at', 'desc')
            ->first();

        $attemptDate = $attempt->created_at->tz(self::TIMEZONE)->toDateString();
        $lastAttemptDate = $lastCalculatedAttempt->created_at->tz(self::TIMEZONE)->toDateString();

        $longestStreak = $qotd->longest_streak;
        $currentStreak = $qotd->current_streak;
        $longestStreakStartAttemptId = $qotd->longest_streak_start_attempt_id;
        $currentStreakStartAttemptId = $qotd->current_streak_start_attempt_id;

        if (Carbon::parse($attemptDate)->diffInDays(Carbon::parse($lastAttemptDate)) === 1) {
            $currentStreak++;
        } else {
            $currentStreak = 1;
            $currentStreakStartAttemptId = $attempt->id;
        }

        if ($currentStreak > $longestStreak) {
            $longestStreak = $currentStreak;
            $longestStreakStartAttemptId = $currentStreakStartAttemptId;
        }

        $player->qotd->update([
            'longest_streak' => $longestStreak,
            'current_streak' => $currentStreak,
            'longest_streak_start_attempt_id' => $longestStreakStartAttemptId,
            'current_streak_start_attempt_id' => $currentStreakStartAttemptId,
            'last_streak_calculated_at' => now(),
        ]);
    }
}
