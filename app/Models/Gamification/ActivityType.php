<?php

namespace App\Models\Gamification;

enum ActivityType: string
{
    case WTW_BONUS_PAGES_DOWNLOADED = 'wtw_bonus';
    case WTW_PURCHASED = 'wtw_purchased';
    case QOTD_PLAYED = 'qotd_played';
    case QOTD_ANSWERED = 'qotd_answered';
    case QOTD_HINT_TAKEN = 'qotd_hint_taken';

    public function label(): string
    {
        return match ($this) {
            self::WTW_BONUS_PAGES_DOWNLOADED => 'What The What?! Bonus Pages Downloaded',
            self::WTW_PURCHASED => 'What The What?! Book Purchased',
            self::QOTD_PLAYED => 'QOTD Played',
            self::QOTD_ANSWERED => 'QOTD Answered',
            self::QOTD_HINT_TAKEN => 'QOTD Hint Taken',
        };
    }

    public function points(): int
    {
        return match ($this) {
            self::WTW_BONUS_PAGES_DOWNLOADED => 150,
            self::QOTD_PLAYED => 10,
            self::QOTD_ANSWERED => 20,
            self::QOTD_HINT_TAKEN => -10,
            default => 0,
        };
    }
}
