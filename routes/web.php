<?php

use App\Actions\GetShopifyOrders;
use App\Actions\CalculateAdminStats;
use App\Enums\MessageStatus;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GiftCodeController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GiftingController;
use App\Http\Controllers\Markbook\BookSearchController;
use App\Http\Controllers\Markbook\MarkbookFeedController;
use App\Http\Controllers\Markbook\MarkbookLeaderboardController;
use App\Http\Controllers\Markbook\ReadingController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\QotdController;
use App\Http\Controllers\QR\ComingSoonController;
use App\Http\Controllers\QR\HelloAuthorsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopifyWebhookController;
use App\Http\Controllers\TotemController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WhatsappWebhookController;
use App\Http\Middleware\QuickHttpBasicAuth;
use App\Models\Player;
use App\Models\Totem;
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
 * TOTEMS
 */
Route::middleware('auth:player')->group(function () {
    Route::get('/totems', [TotemController::class, 'index'])->name('totems.index');
    Route::put('/totems/{totem}/progress', [TotemController::class, 'updateProgress'])->name('totems.update-progress');
});

/**
 * MARKBOOK
 */
Route::middleware('auth:player')->group(function () {
    Route::get('/markbook', [MarkbookFeedController::class, 'index'])->name('markbook.feed');
    Route::post('/markbook/readings', [ReadingController::class, 'store'])->name('markbook.readings.store');
    Route::get('/markbook/leaderboard/{duration}', [MarkbookLeaderboardController::class, 'index'])->name('markbook.leaderboard'); // weekly, monthly, all-time
});

/**
 * CURIOSITY GAME
 */
Route::middleware('auth:player')->group(function () {
    Route::get('/game', [GameController::class, 'index'])->name('game.index');
});


/**
 * QR CODES
 */
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware(['auth:player']);

Route::get('/hello-authors', [HelloAuthorsController::class, 'show'])->name('qr.hello_authors');

Route::get('/qr/coming-soon', [ComingSoonController::class, 'show'])->name('qr.coming_soon');
Route::post('/qr/coming-soon/subscription', [ComingSoonController::class, 'subscribe'])->name('qr.coming_soon.subscribe')->middleware('auth:player');

/**
 * WEBHOOKS
 */
Route::get('/webhooks/whatsapp', [WhatsappWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsappWebhookController::class, 'handle']);
Route::post('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);
Route::post('/webhooks/shopify', ShopifyWebhookController::class);


if (app()->environment('local')) {
    Route::get('login-as-player/{player}', function (Player $player) {
        auth()->guard('player')->login($player);
        return redirect('/');
    });
    Route::get('/webhooks/shopify/test', ShopifyWebhookController::class);
    Route::get('/webhooks/whatsapp/force-send', [WhatsappWebhookController::class, 'forceSend']);
    Route::get('/webhooks/whatsapp/test', [WhatsappWebhookController::class, 'test']);


    Route::get('/test', function () {
        try {
            $response = Shopify::admin()->call('admin/getCustomers', [
                'query' =>
                collect([
                    8662193995955,
                    8655558213811,
                    8720687923379,
                    8766221287603,
                    7567484747955,
                    8952049664179,
                    8726760718515,
                    8655509717171,
                    7944985247923,
                    8673496170675,
                    8658461425843,
                    8693464268979,
                    8260306665651,
                    8778756194483,
                    8284210331827,
                    8658095308979,
                    8658890096819,
                    8717123682483,
                    8783081865395,
                    8658899140787,
                    8660116832435,
                    8777411428531,
                    8656963666099,
                    8757464858803,
                    8712915091635,
                    8713649488051,
                    8690363334835,
                    8712496545971,
                    8286407295155,
                    8717734543539,
                    8655511945395,
                    8713309618355,
                    8768902398131,
                    8760915951795,
                    8762329301171,
                    8764151922867,
                    8693581152435,
                    8659202179251,
                    8761095946419,
                    8773673124019,
                    8656970121395,
                    8757308096691,
                    8749290586291,
                    8663300112563,
                    8659119079603,
                    8884623540403,
                    8665586827443,
                    8668607021235,
                    8783241871539,
                    8659942768819,
                    8663398711475,
                    8657063116979,
                    8681625125043,
                    8767395561651,
                    8654084145331,
                    8884622786739,
                    8676735877299,
                    8659936051379,
                    8724865417395,
                    8656964026547,
                    8779419418803,
                    8659571278003,
                    8761171869875,
                    8679391068339,
                    8351499321523,
                    7778594259123,
                    8658704335027,
                    8765367648435,
                    8658835636403,
                    8674094645427,
                    8659190251699,
                    8654500659379,
                    8663285399731,
                    8767626739891,
                    7906921185459,
                    8690321490099,
                    8693531214003,
                    8653661569203,
                    8661740552371,
                    8713022800051,
                    8758803398835,
                    8655507718323,
                    8911853584563,
                    8902665568435,
                    8721021206707,
                    8660449198259,
                    8663269212339,
                    8680592244915,
                    8785135468723,
                    8756525269171,
                    8661509406899,
                    8663336517811,
                    8715183128755,
                    8758615343283,
                    8778288693427,
                    8670988599475,
                    8658887213235,
                    8655581642931,
                    8762227359923,
                    8650093953203,
                    8693528166579,
                    8656966680755,
                    8663281893555,
                    8657032904883,
                    8655538553011,
                    8722335858867,
                    8657053941939,
                    8660337524915,
                    7780171022515,
                    8768148635827,
                    8765307748531,
                    8761952796851,
                    8675241787571,
                    8655524397235,
                    7782374867123,
                    8663084073139,
                    8748173754547,
                    8659151716531,
                    8661516320947,
                    8662196289715,
                    8663442260147,
                    8664746164403,
                    8658678644915,
                    8736608714931,
                    8756941226163,
                    8668360212659,
                    8726459482291
                ])
                    ->map(fn($id) => 'id:' . $id)
                    ->join(' OR ')
            ]);

            dd($response);
        } catch (ShopifyException $e) {
            dd($e->context());
        }
    });
}
