<?php

namespace App\Console\Commands;

use App\Actions\Gifting\CreateGift;
use App\Actions\Gifting\CreateGiftCodes;
use App\Actions\SendGiftConfirmationOnWhatsapp;
use App\Actions\SendOrderConfirmationOnWhatsapp;
use App\Models\Gamification\Activity;
use App\Models\Gamification\ActivityType;
use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessPendingGiftPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-gift-purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates gifts, gift codes and sends confirmation messages for pending gift purchases.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingActivities = Activity::with('owner')
            ->where('type', ActivityType::WTW_GIFTED)
            ->whereDoesntHave('owner.giftsGiven', function ($query) {
                $query->where('shopify_order_id', '=', DB::raw('JSON_EXTRACT(meta, \'$.order_id\')'));
            })
            ->orderBy('occurred_at', 'asc')
            ->get();

        $this->info(sprintf("Pending: %d", $pendingActivities->count()));
        foreach ($pendingActivities as $index => $activity) {
            $this->info(sprintf('[%d/%d]', $index + 1, $pendingActivities->count()));

            // Create Gift, Gift Codes and send confirmation
            $gift = (new CreateGift)($activity);
            (new CreateGiftCodes)($gift);
            (new SendGiftConfirmationOnWhatsapp)($activity, $gift);

            $this->info("Gift confirmation sent for activity ID: {$activity->id}");
        }

        $this->info('Success!');
    }
}
