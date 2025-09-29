<?php

foreach (\App\Models\Player::doesntHave('wallet')->cursor() as $player) {
    echo $player->id . PHP_EOL;
    $player->wallet()->firstOrCreate();
}
