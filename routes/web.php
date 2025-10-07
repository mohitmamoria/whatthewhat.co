<?php

use App\Actions\Analytics\GetShopifyOrders;
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
    $total = App\Models\Player::count();
    $withWallet = App\Models\Player::whereHas('wallet', function ($q) {
        $q->where('balance', '>', 0);
    })->count();

    $invitedPlayers = App\Models\Player::whereHas('activities', function ($query) {
        $query->where('type', App\Models\Gamification\ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
    })->whereHas('messages', function ($query) {
        $query->where('body->content', '__t:preorders_invite');
    })->count();

    try {
        $response = Shopify::admin()->call('admin/getAnalytics', [
            'query' => "FROM sales
                SHOW net_items_sold, gross_sales, discounts, returns, net_sales, taxes,
                    total_sales
                WHERE product_title = 'What The What?!'
                GROUP BY product_title, product_variant_title, product_variant_sku
                    WITH TOTALS, CURRENCY 'INR'
                SINCE startOfDay(-90d) UNTIL today
                ORDER BY total_sales DESC
                LIMIT 1000
                VISUALIZE total_sales TYPE horizontal_bar"
        ]);
    } catch (ShopifyException $e) {
        dd($e->context());
    }

    $rows = data_get(
        $response,
        'shopifyqlQuery.tableData.rows'
    );

    $rows = collect($rows)->select(['product_variant_sku', 'net_items_sold']);

    $booksSold = $rows->sum(function ($row) {
        $count = (int) $row['net_items_sold'];

        // duo variant counts as 2 books per sale
        if (str_contains($row['product_variant_sku'], 'duo')) {
            $count *= 2;
        }

        return $count;
    });

    $calendarsSold = $rows->sum(function ($row) {
        // only calendar variant counts
        if (!str_contains($row['product_variant_sku'], 'calendar')) {
            return 0;
        }

        $count = (int) $row['net_items_sold'];

        // duo variant counts as 2 calendarts per sale
        if (str_contains($row['product_variant_sku'], 'duo')) {
            $count *= 2;
        }

        return $count;
    });

    return nl2br(sprintf("Total Players: %d \n\n Players With Bonus Pages: %d \n\n Players invited to order: %d \n\n Books Sold: %d (%d without Brainiest) \n\n Calendars Sold: %d", $total, $withWallet, $invitedPlayers, $booksSold, $booksSold - 74, $calendarsSold));

    return compact('total', 'withWallet', 'booksSold', 'calendarsSold');
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


    Route::get('/test', function () {
        try {

            $response = Shopify::admin()->call('admin/getOrder', ['id' => 'gid://shopify/Order/6257618157747']);

            dd($response);
        } catch (ShopifyException $e) {
            dd($e->context());
        }
    });
}
