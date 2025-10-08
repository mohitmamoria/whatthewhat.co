<?php

use App\Actions\Analytics\GetShopifyOrders;
use App\Actions\CalculateAdminStats;
use App\Enums\MessageStatus;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WhatsappWebhookController;
use App\Services\Shopify\Shopify;
use App\Services\Shopify\ShopifyException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/count', function () {
    return (new CalculateAdminStats)();
});

Route::get('/buy', [ShopController::class, 'buy'])->name('shop.buy');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

Route::get('/webhooks/whatsapp', [WhatsappWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsappWebhookController::class, 'handle']);
Route::post('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);

Route::post('/webhooks/shopify', function (Request $request) {
    $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
    $data = $request->getContent();

    $calculated = base64_encode(
        hash_hmac('sha256', $data, config('services.shopify.webhook_verify_token'), true)
    );

    Log::info('SHOPIFY_WEBHOOK_1', [$hmacHeader, $calculated]);

    // Decode it for easier logging
    $payload = json_decode($data, true);

    Log::info('SHOPIFY_WEBHOOK_2',  [
        'headers' => $request->headers->all(),
        'body' => $payload,
    ]);
});

if (app()->environment('local')) {
    Route::get('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);
    Route::get('/webhooks/whatsapp/test', [WhatsappWebhookController::class, 'test']);


    Route::get('/test', function () {
        try {

            $response = Shopify::admin()->call('admin/getOrder', ['id' => 'gid://shopify/Order/6257618157747']);

            dd($response);
        } catch (ShopifyException $e) {
            dd($e->context());
        }
    });
}
