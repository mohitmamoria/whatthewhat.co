<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
use App\Enums\MessageStatus;
use App\Models\Message;
use App\Models\Player;
use Illuminate\Console\Command;

class RetryFailedPreorderInvites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retry-failed-invites {threshold_days=2 : Only retry invites that failed more than this many days ago}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry failed preorder invites';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = Message::TEMPLATE_PREFIX . 'preorders_invite';

        $daysThreshold = $this->argument('threshold_days');
        $thresholdDate = now()->subDays($daysThreshold);

        $players = Player::whereHas('messages', function ($query) use ($message, $thresholdDate) {
            $query->where('body->content', $message)
                ->where('status', MessageStatus::FAILED)
                ->whereRaw('created_at = (SELECT MAX(created_at) FROM messages WHERE player_id = players.id AND status = ?)', [MessageStatus::FAILED])
                ->where('created_at', '<', $thresholdDate);
        })->whereDoesntHave('messages', function ($query) use ($message) {
            $query->where('body->content', $message)->whereNot('status', MessageStatus::FAILED);
        })->get();

        foreach ($players as $index => $player) {
            usleep(100_000); // pause for 100ms
            $this->info($index + 1 . '/' . $players->count());
            $this->call('app:invite-to-preorder', ['phone' => $player->number, 'count' => 1]);
        }
    }
}
