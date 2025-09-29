<?php

foreach (\App\Models\Player::doesntHave('wallet')->cursor() as $player) {
    $player->wallet()->firstOrCreate();
}
