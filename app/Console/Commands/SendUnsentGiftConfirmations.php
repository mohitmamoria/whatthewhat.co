<?php

namespace App\Console\Commands;

use App\Actions\SendGiftConfirmationOnWhatsapp;
use App\Actions\SendOrderConfirmationOnWhatsapp;
use App\Models\Gamification\Activity;
use App\Models\Gamification\ActivityType;
use App\Models\Message;
use Illuminate\Console\Command;

class SendUnsentGiftConfirmations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-gift-confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the gift confirmations that have not been sent yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingActivities = Activity::with('owner')
            ->where('type', ActivityType::WTW_GIFTED)
            ->whereDoesntHave('owner.messages', function ($query) {
                $query->where('body->content', Message::TEMPLATE_PREFIX . SendGiftConfirmationOnWhatsapp::TEMPLATE_GIFT_CONFIRMATION);
            })
            ->orderBy('occurred_at', 'asc')
            ->get();

        $this->info(sprintf("Pending: %d", $pendingActivities->count()));
        foreach ($pendingActivities as $index => $activity) {
            $this->info(sprintf('[%d/%d]', $index + 1, $pendingActivities->count()));
            (new SendGiftConfirmationOnWhatsapp)($activity);

            $this->info("Gift confirmation sent for activity ID: {$activity->id}");
        }

        $this->info('Success!');
    }
}
