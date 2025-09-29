<?php

foreach (App\Models\Player::whereNull('referrer_code')->cursor() as $player) {
    $player->referrer_code = get_unique_referrer_code($player);
    echo sprintf("Player %d: %s\n", $player->id, $player->referrer_code);
    // $player->save();
}
