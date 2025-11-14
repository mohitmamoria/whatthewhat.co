<?php

namespace App\Actions\Markbook;

class CalculateMarkbookStats
{
    public function __invoke($player)
    {
        $totalBooks = $player->readings()->distinct('book_id')->count('book_id');
        $totalPagesRead = (int) $player->readings()->sum('pages_read');
        $lastReading = $player->readings()->latest()->first();

        return [
            'total_books_read' => $totalBooks,
            'total_pages_read' => $totalPagesRead,
            'last_reading_pages' => $lastReading->pages_read ?? 0,
        ];
    }
}
