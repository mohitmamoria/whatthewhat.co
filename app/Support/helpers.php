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
            // if name is less than 4 chars, generate random letter to fill in the gap
            if (strlen($name) < 5) {
                $name .= Str::random(5 - strlen($name));
            }

            $code = str($name)
                ->before(' ')->replaceMatches('/[^a-zA-Z0-9]/', '')->substr(0, 7) // first name part, max 7 chars
                ->append(strlen($player->number) >= 4 ? substr($player->number, -4) : $player->number) // last 4 digits of phone number
                ->append($random);

            $random = Str::random(3);

            $code = $code->upper()->toString();
        } while (Player::where('referrer_code', $code)->exists());

        return $code;
    }
}
