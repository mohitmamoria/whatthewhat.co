<?php

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

Route::get('/buy', [ShopController::class, 'buy'])->name('shop.buy');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

Route::get('/count', function () {
    return sprintf(
        "%d of %d",
        App\Models\Player::whereHas('wallet', function ($q) {
            $q->where('balance', '>', 0);
        })->count(),
        App\Models\Player::count(),
    );
});

Route::get('/webhooks/whatsapp', [WhatsappWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsappWebhookController::class, 'handle']);
Route::post('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);

if (app()->environment('local')) {

    Route::post('/webhooks/shopify', function (Request $request) {
        $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
        $data = $request->getContent();

        $calculated = base64_encode(
            hash_hmac('sha256', $data, 'f2fda8925c4b471472641405ea3b6d463a0b039b9d6d155898721d6cd63e4554', true)
        );

        Log::info('Shopify webhook verification', [$hmacHeader, $calculated]);

        // Decode it for easier logging
        $payload = json_decode($data, true);

        Log::info('Shopify Webhook Received: ',  [
            'headers' => $request->headers->all(),
            'body' => $payload,
        ]);
    });

    Route::get('/test', function () {
        try {
            $response = Shopify::storefront()->call('storefront/createCart', [
                'input' => [
                    'buyerIdentity' => [
                        'phone' => '+919716313713',
                    ],
                    'attributes' => [
                        ['key' => 'ref', 'value' => 'preorder-campaign'],
                    ],
                    'lines' => [
                        ['merchandiseId' => "gid://shopify/ProductVariant/45025566195891", 'quantity' => 1],
                    ],
                ]
            ]);

            $checkoutUrl = data_get($response, 'cartCreate.cart.checkoutUrl');

            if ($checkoutUrl) {
                return redirect($checkoutUrl);
            }

            dd($response);
        } catch (ShopifyException $e) {
            dd($e->context());
        }
    });

    Route::get('/products/{id}', function ($id) {
        try {
            $response = Shopify::admin()->call('admin/getProduct', ['id' => 'gid://shopify/Product/' . $id]);

            dd($response);
        } catch (ShopifyException $e) {
            dd($e->context());
        }
    });
}
