<?php

use App\Console\Commands\InvitePlayerToPreorder;
use App\Console\Commands\SendUnsentOrderConfirmations;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(InvitePlayerToPreorder::class, ['1000'])->hourly()->withoutOverlapping();
Schedule::command(SendUnsentOrderConfirmations::class)->everyFiveMinutes()->withoutOverlapping();
