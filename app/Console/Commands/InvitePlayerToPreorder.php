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
    protected $signature = 'app:invite-to-preorder {count : How many invites to send?}';

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

        $players = Player::whereHas('activities', function ($query) {
            $query->where('type', ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
        })->whereDoesntHave('messages', function ($query) use ($message) {
            $query->where('body->content', $message);
        })->oldest()->limit($count)->get();

        foreach ($players as $player) {
            usleep(100_000); // pause for 100ms
            $this->info(sprintf('Player:: %d: %s (%s)', $player->id, $player->name, $player->number));
            $messageModel = (new SendMessageOnWhatsapp)($player, $message, [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $player->name,
                        ],
                    ],
                ],
            ]);
            $this->info($messageModel->__toString());
        }
    }
}
