<?php

namespace App\Actions\Markbook;

class CalculateMarkbookStats
{
    public function __invoke($player)
    {
        $totalPagesRead = (int) $player->readings()->sum('pages_read');
        $lastReading = $player->readings()->latest()->first();

        return [
            'total_pages_read' => $totalPagesRead,
            'last_reading_pages' => $lastReading->pages_read ?? 0,
        ];
    }
}
