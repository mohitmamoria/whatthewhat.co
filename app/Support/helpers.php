<?php

use App\Models\Player;
use Illuminate\Support\Str;

if (! function_exists('p')) {
    function p($id): ?Player
    {
        return Player::find($id);
    }
}

if (! function_exists('normalize_text')) {
    function normalize_text(string $text): string
    {
        // 1. Normalize Unicode (separates accents, decomposes)
        if (class_exists(\Normalizer::class)) {
            $text = \Normalizer::normalize($text, \Normalizer::FORM_KD);
        }

        // 2. Convert Unicode "fancy" chars to ASCII
        $text = Str::ascii($text);

        // 3. Remove emojis, symbols, hieroglyphs, etc.
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);

        // 4. Trim multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }
}

if (!function_exists('get_unique_referrer_code')) {
    function get_unique_referrer_code(Player $player): string
    {
        $random = '';
        do {
            $name = normalize_text($player->name);

            $code = str($name)
                ->before(' ')->replaceMatches('/[^a-zA-Z0-9]/', '')->substr(0, 7) // first name part, max 7 chars
                ->padRight(5, Str::random(5)) // pad with random if name is too short
                ->append(strlen($player->number) >= 4 ? substr($player->number, -4) : $player->number) // last 4 digits of phone number
                ->append($random);

            $random = Str::random(3);

            $code = $code->upper()->toString();
        } while (Player::where('referrer_code', $code)->exists());

        return $code;
    }
}

if (! function_exists('normalize_phone')) {
    function normalize_phone(string $phone): string
    {
        // Replaces any character that is not a digit with an empty string
        // +91 98765 43210 -> 919876543210
        // +1 (123) 456-7890 -> 11234567890
        return preg_replace('/\D/', '', $phone);
    }
}

if (! function_exists('obfuscate_phone')) {
    /**
     * Obfuscate a phone number showing only the first N and last M digits.
     *
     * Examples:
     *  obfuscate_phone('919876543210')          => '+91*******210'
     *  obfuscate_phone('919876543210', 3, 2)    => '+919******10'
     *  obfuscate_phone('98765', 2, 2)           => '+98*65'
     *
     */
    function obfuscate_phone(string $phone, int $showStart = 2, int $showEnd = 2, string $mask = '*'): string
    {
        // Keep only digits
        $digits = preg_replace('/\D+/', '', $phone ?? '');
        $len = strlen($digits);

        if ($len === 0) {
            return '';
        }

        // If too short
        if ($len < ($showStart + $showEnd)) {
            $showStart = max(1, intdiv($len, 2));
            $showEnd   = $len - $showStart;
        }

        $first = substr($digits, 0, $showStart);
        $last  = substr($digits, -$showEnd);
        $middleLen = max(0, $len - $showStart - $showEnd);
        $middle = str_repeat($mask, $middleLen);

        return '+' . $first . $middle . $last;
    }
}
