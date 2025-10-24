<?php

use App\Console\Commands\InvitePlayerToPreorder;
use App\Console\Commands\ProcessPendingGiftPurchases;
use App\Console\Commands\SendUnsentGiftConfirmations;
use App\Console\Commands\SendUnsentOrderConfirmations;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(InvitePlayerToPreorder::class, ['1000'])->hourly()->sendOutputTo(storage_path('logs/invite_player_to_preorder.log'));
Schedule::command(SendUnsentOrderConfirmations::class)->everyMinute()->sendOutputTo(storage_path('logs/send_unsent_order_confirmations.log'));
Schedule::command(ProcessPendingGiftPurchases::class)->everyMinute()->sendOutputTo(storage_path('logs/process_pending_gift_purchases.log'));
