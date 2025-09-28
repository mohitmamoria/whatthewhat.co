<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WhatsappWebhookController;
use App\Services\Shopify\Shopify;
use App\Services\Shopify\ShopifyException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/count', function () {
    return sprintf(
        "%d of %d",
        App\Models\Player::where('updated_at', '>=', Carbon\Carbon::parse('09 Sept 2025')->startOfDay())->count(),
        App\Models\Player::count(),
    );
});

Route::get('/webhooks/whatsapp', [WhatsappWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsappWebhookController::class, 'handle']);
Route::post('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);

if (app()->environment('local')) {
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
