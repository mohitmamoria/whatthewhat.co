<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
use App\Models\Gamification\ActivityType;
use App\Models\Message;
use App\Models\Player;
use Illuminate\Console\Command;

class RemindPlayersToPreorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-to-preorder {count : How many reminders to send?} {template=preorders_last_chance : Template to use for the reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind players to pre-order if they have not done so already.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');

        $players = Player::whereHas('activities', function ($query) {
            $query->where('type', ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
        })->whereDoesntHave('activities', function ($query) {
            $query->where('type', ActivityType::WTW_PURCHASED);
        })->oldest()->limit($count)->get();

        foreach ($players as $index => $player) {
            usleep(100_000); // pause for 100ms
            $this->info($index + 1 . '/' . $players->count());
            $this->sendReminder($player);
        }
    }

    /**
     * Send a reminder to the given player.
     */
    private function sendReminder(Player $player): void
    {
        $message = Message::TEMPLATE_PREFIX . $this->argument('template');

        $this->info(sprintf('Player:: %d: %s (%s)', $player->id, $player->name, $player->number));
        $messageModel = (new SendMessageOnWhatsapp)($player, $message);

        if ($messageModel) {
            $this->info('Message sent successfully.');
            $this->info($messageModel->toJson());
        } else {
            $this->error('Failed to send message.');
        }
    }
}
