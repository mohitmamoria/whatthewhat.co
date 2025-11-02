<?php

$received = App\Models\GiftCode::with('receiver')->received()->get();

$unnamed = [];
foreach ($received as $giftCode) {
    $receiver = $giftCode->receiver;
    if (strtolower($receiver->name) === 'player') {
        echo "Gift Code ID: {$giftCode->id}, Receiver ID: {$receiver->id}, Receiver Number: {$receiver->number}\n";
        $unnamed[] = $giftCode;
    }
}

$activities = [];
foreach ($unnamed as $giftCode) {
    $receiver = $giftCode->receiver;

    $activities[$giftCode->name] = [
        'number' => $receiver->number,
        'activities' => $receiver->activities()->pluck('type')->map(fn($a) => $a->value)->toArray(),
    ];
}
