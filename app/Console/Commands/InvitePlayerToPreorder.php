<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
use App\Enums\MessagePlatform;
use App\Models\Gamification\ActivityType;
use App\Models\Message;
use App\Models\Player;
use Illuminate\Console\Command;

class InvitePlayerToPreorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:invite-to-preorder {count : How many invites to send?} {phone? : Phone number of the player to invite}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invites the user to the place their pre-orders.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = Message::TEMPLATE_PREFIX . 'preorders_invite';

        $count = (int) $this->argument('count');
        $phone = $this->argument('phone');

        if ($phone) {
            $player = Player::where('number', $phone)->first();

            if (!$player) {
                $this->error('Player with the given phone number not found.');
                return;
            }

            $this->sendInvite($player, $message);
            return;
        }

        $players = Player::whereHas('activities', function ($query) {
            $query->where('type', ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
        })->whereDoesntHave('messages', function ($query) use ($message) {
            $query->where('body->content', $message);
        })->oldest()->limit($count)->get();

        foreach ($players as $index => $player) {
            usleep(100_000); // pause for 100ms
            $this->info($index + 1 . '/' . $players->count());
            $this->sendInvite($player, $message);
        }
    }

    /**
     * Send an invite to the given player.
     */
    private function sendInvite(Player $player, string $message): void
    {
        $this->info(sprintf('Player:: %d: %s (%s)', $player->id, $player->name, $player->number));
        $messageModel = (new SendMessageOnWhatsapp)($player, $message, [
            [
                "type" => "body",
                "parameters" => [
                    [
                        "type" => "text",
                        "text" => normalize_text($player->name) ?: 'there!',
                    ],
                ],
            ],
        ]);

        if ($messageModel) {
            $this->info('Message sent successfully.');
            $this->info($messageModel->toJson());
        } else {
            $this->error('Failed to send message.');
        }
    }
}
