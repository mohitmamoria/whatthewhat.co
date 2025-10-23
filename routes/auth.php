<?php

use App\Http\Controllers\Auth\PlayerAuthController;
use Illuminate\Support\Facades\Route;

include_once __DIR__ . '/auth.php';

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/players/login', [PlayerAuthController::class, 'login'])->name('player.login');
    Route::post('/players/otp', [PlayerAuthController::class, 'otp'])->name('player.otp');
    Route::post('/players/verify', [PlayerAuthController::class, 'verify'])->name('player.verify');
    Route::post('/players/logout', [PlayerAuthController::class, 'logout'])->name('player.logout');
});
