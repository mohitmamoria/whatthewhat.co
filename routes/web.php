<?php

use App\Actions\GetShopifyOrders;
use App\Actions\CalculateAdminStats;
use App\Enums\MessageStatus;
use App\Http\Controllers\GiftCodeController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GiftingController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\QotdController;
use App\Http\Controllers\QR\ComingSoonController;
use App\Http\Controllers\QR\HelloAuthorsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopifyWebhookController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WhatsappWebhookController;
use App\Http\Middleware\QuickHttpBasicAuth;
use App\Services\Shopify\Shopify;
use App\Services\Shopify\ShopifyException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__ . '/auth.php';

Route::get('/', [ShopController::class, 'buy'])->name('home');

Route::get('/count', function () {
    return (new CalculateAdminStats)();
})->middleware(QuickHttpBasicAuth::class);

Route::get('/buy', function (Request $request) {
    return redirect()->route('home', $request->query());
})->name('shop.buy');
Route::get('/gift', [ShopController::class, 'buyForGifting'])->name('shop.gift');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

/**
 * GIFTING
 */
Route::get('/g', [GiftController::class, 'luckyOne'])->middleware(QuickHttpBasicAuth::class);
Route::get('/gifts/lucky/{code}', [GiftController::class, 'lucky'])->name('gift.lucky');
Route::get('/gifts/{gift:name}', [GiftController::class, 'show'])->name('gift.show');
Route::middleware('auth:player')->group(function () {
    Route::post('/gifts/{gift:name}/reserve', [GiftController::class, 'reserve'])->name('gift.reserve');
    Route::get('/gifts/{gift:name}/codes/{giftCode:name}', [GiftCodeController::class, 'show'])->name('gift_code.show');
    Route::post('/gifts/{gift:name}/codes/{giftCode:name}/checkout', [GiftCodeController::class, 'checkout'])->name('gift_code.checkout');
});

/**
 * QOTD
 */
Route::get('/qotd', [QotdController::class, 'index'])->name('qotd.index');
Route::middleware('auth:player')->group(function () {
    Route::post('/qotd/join', [QotdController::class, 'join'])->name('qotd.join');
    Route::get('/qotd/stats', [QotdController::class, 'stats'])->name('qotd.stats');
    Route::post('/qotd/{question:name}/attempts', [QotdController::class, 'attempt'])->name('qotd.attempts');
    Route::get('/qotd/attempts/{attempt:name}', [QotdController::class, 'play'])->name('qotd.play');
    Route::post('/qotd/attempts/{attempt:name}/answers', [QotdController::class, 'answer'])->name('qotd.answer');
    Route::post('/qotd/attempts/{attempt:name}/timedout', [QotdController::class, 'timeout'])->name('qotd.timeout');
});

/**
 * WEBHOOKS
 */
Route::get('/webhooks/whatsapp', [WhatsappWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsappWebhookController::class, 'handle']);
Route::post('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);

Route::post('/webhooks/shopify', ShopifyWebhookController::class);


/**
 * QR CODES
 */
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware(['auth:player']);

Route::get('/hello-authors', [HelloAuthorsController::class, 'show'])->name('qr.hello_authors');

Route::get('/qr/coming-soon', [ComingSoonController::class, 'show'])->name('qr.coming_soon');
Route::post('/qr/coming-soon/subscription', [ComingSoonController::class, 'subscribe'])->name('qr.coming_soon.subscribe')->middleware('auth:player');

if (app()->environment('local')) {
    Route::get('/webhooks/shopify/test', ShopifyWebhookController::class);
    Route::get('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);
    Route::get('/webhooks/whatsapp/test', [WhatsappWebhookController::class, 'test']);


    Route::get('/test', function () {
        try {
            $response = Shopify::admin()->call('admin/getOrder', ['id' => 'gid://shopify/Order/6283878072499']);

            dd($response);
        } catch (ShopifyException $e) {
            dd($e->context());
        }
    });
}
