<?php

namespace App\Console\Commands;

use App\Models\Gamification\ActivityType;
use App\Models\GiftCode;
use App\Services\Shopify\Shopify;
use Illuminate\Console\Command;

class CancelAllAbusedGiftCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-abused-gift-codes {--act : Actually cancel the gift codes (NO DRY RUN)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancels all gift codes that have been abused, and make them available to be claimed again.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $codes = GiftCode::with('receiver')->received()->get();

        foreach ($codes as $code) {
            $receiver = $code->receiver;

            $activities = $receiver->activities()->ofType(ActivityType::WTW_PURCHASED)->get();
            $this->info(sprintf('Gift Code: %s; Receiver: %s (%s); Order Count: %d', $code->name, $receiver->number, $receiver->name, $activities->count()));

            $orders = $activities->map(fn($a) => $a->meta['order_id'] ?? null)->filter()->unique();
            foreach ($orders as $orderId) {
                $this->info(sprintf('Checking Order ID: %s', $orderId));
                if ($this->isGiftedOrder($orderId)) {
                    $this->info(sprintf('🚨 [MUST BE CANCELED] Order ID: %s; Gift Code: %s', $orderId, $code->name));
                    if ($this->option('act')) {
                    }
                } else {
                    $this->info('✅ OK.');
                }
            }
        }
    }

    protected function isGiftedOrder(string $orderId): bool
    {
        $order = Shopify::admin()->call('admin/getOrder', ['id' => $orderId]);

        $customAttributes = data_get($order, 'order.customAttributes', []);

        $giftAttributes = collect($customAttributes)->whereIn('key', ['giftcode', 'receiver'])->all();

        return count($giftAttributes) > 0;
    }
}
