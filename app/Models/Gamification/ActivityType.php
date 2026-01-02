<?php

namespace App\Models\Gamification;

enum ActivityType: string
{
    case WTW_BONUS_PAGES_DOWNLOADED = 'wtw_bonus';
    case WTW_REFERRED = 'wtw_referred';
    case WTW_PURCHASED = 'wtw_purchased';
    case WTW_GIFTED = 'wtw_gifted';
    case QOTD_JOINED = 'qotd_joined';
    case QOTD_ATTEMPTED = 'qotd_attempted';
    case QOTD_ANSWERED = 'qotd_answered';
    case QOTD_REFERRED = 'qotd_referred';
    case QOTD_HINT_TAKEN = 'qotd_hint_taken';
    case TOTEM_COLLECTED = 'totem_collected';

    public function label(): string
    {
        return match ($this) {
            self::WTW_BONUS_PAGES_DOWNLOADED => 'What The What?! Bonus Pages Downloaded',
            self::WTW_REFERRED => 'What The What?! Book Referred',
            self::WTW_PURCHASED => 'What The What?! Book Purchased',
            self::WTW_GIFTED => 'What The What?! Book Gifted',
            self::QOTD_JOINED => 'QOTD Joined',
            self::QOTD_ATTEMPTED => 'QOTD Attempted',
            self::QOTD_ANSWERED => 'QOTD Answered',
            self::QOTD_REFERRED => 'QOTD Referred',
            self::QOTD_HINT_TAKEN => 'QOTD Hint Taken',
            self::TOTEM_COLLECTED => 'Totem Collected',
        };
    }

    public function points(): int
    {
        return match ($this) {
            self::WTW_BONUS_PAGES_DOWNLOADED => 150,
            self::QOTD_JOINED => 100,
            self::QOTD_ATTEMPTED => 10,
            self::QOTD_ANSWERED => 20,
            self::QOTD_REFERRED => 100,
            self::QOTD_HINT_TAKEN => -10,
            self::TOTEM_COLLECTED => 100,
            default => 0,
        };
    }
}
