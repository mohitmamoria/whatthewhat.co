<?php

namespace App\Actions\Qotd;

use App\Models\Player;

class UpdateQotdStats
{
    public function __invoke(Player $player): void
    {
        $totalAttempted = $player->attempts()->count();
        $totalAnswered = $player->attempts()->correct()->count();

        $answeredPercent = $totalAttempted > 0 ? round(($totalAnswered / $totalAttempted), 2) * 100 : 0;

        $averageTimeTaken = round($player->attempts()->correct()->avg('time_spent'), 2);

        // TBD: Calculate longest and current streaks

        $player->qotd->update([
            'total_attempted' => $totalAttempted,
            'total_answered' => $totalAnswered,
            'answered_percent' => $answeredPercent,
            'average_time_taken' => $averageTimeTaken,
        ]);
    }
}
