<?php

namespace App\Actions\Qotd;

use App\Models\Player;
use Illuminate\Support\Carbon;

class RecalculateQotdStreaks
{
    const TIMEZONE = 'Asia/Kolkata';

    public function __invoke(Player $player, ?Carbon $from = null): void
    {
        if ($from === null) {
            $from = $player->qotd->joined_on;
        }

        $attempts = $player->attempts()
            ->where('created_at', '>=', $from)
            ->orderBy('created_at', 'asc')
            ->get();

        $longestStreak = 0;
        $currentStreak = 0;
        $longestStreakStartAttemptId = null;
        $currentStreakStartAttemptId = null;
        $lastAttemptDate = null;
        foreach ($attempts as $attempt) {
            $attemptDate = $attempt->created_at->tz(self::TIMEZONE)->toDateString();

            $longestStreakStartAttemptId = $currentStreakStartAttemptId = $attempt->id;

            if ($lastAttemptDate === null || Carbon::parse($lastAttemptDate)->diffInDays(Carbon::parse($attemptDate)) === 1.0) {
                $currentStreak++;
            } else {
                $currentStreak = 1;
                $currentStreakStartAttemptId = $attempt->id;
            }

            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
                $longestStreakStartAttemptId = $currentStreakStartAttemptId;
            }

            $lastAttemptDate = $attemptDate;
        }

        // If the last attempt day was sometime before yesterday (i.e., more than 1 day ago), make the current streak 0
        if (
            !is_null($lastAttemptDate) &&
            Carbon::parse($lastAttemptDate, self::TIMEZONE)->diffInDays(now()->tz(self::TIMEZONE)) >= 2.0
        ) {
            $currentStreak = 0;
            $currentStreakStartAttemptId = null;
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
