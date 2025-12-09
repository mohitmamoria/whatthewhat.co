<?php

namespace App\Actions\Qotd;

use App\Models\Attempt;
use App\Models\Player;

class PatchQotdStats
{
    public function __invoke(Player $player, Attempt $attempt): void
    {
        $qotd = $player->qotd;

        $totalAttempted = $qotd->total_attempted + 1;
        $totalAnswered = $qotd->total_answered + ($attempt->is_correct ? 1 : 0);

        $answeredPercent = $totalAttempted > 0 ? round(($totalAnswered / $totalAttempted), 2) * 100 : 0;

        // Calculate the new average time taken by adding the current attempt's time to the weighted total
        // of previous attempts, then dividing by the new total number of answered attempts.
        // Formula: ((previous_average * previous_count) + new_value) / new_count
        if ($totalAnswered === 0) {
            $averageTimeTaken = 0;
        } else {
            $averageTimeTaken = round(((($qotd->average_time_taken * $qotd->total_answered) + $attempt->time_spent) / $totalAnswered), 2);
        }

        $player->qotd->update([
            'total_attempted' => $totalAttempted,
            'total_answered' => $totalAnswered,
            'answered_percent' => $answeredPercent,
            'average_time_taken' => $averageTimeTaken,
        ]);
    }
}
