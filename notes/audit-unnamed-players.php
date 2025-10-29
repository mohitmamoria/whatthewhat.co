<?php

$players = App\Models\Player::where('name', 'Player')->get();

foreach ($players as $player) {
    echo $player->name . ' - ' . $player->number . "\n";
    $player->activities()->where('type', App\Models\Gamification\ActivityType::WTW_GIFT_RECEIVED)->get()->each(function ($activity) {
        echo " Activity ID: " . $activity->id . "\n";
    });
}
