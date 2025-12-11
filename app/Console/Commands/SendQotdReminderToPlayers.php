<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
use App\Enums\MessageDirection;
use App\Models\Message;
use App\Models\Player;
use App\Models\Question;
use Illuminate\Console\Command;

class SendQotdReminderToPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:qotd-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send QOTD reminder to players who have not played yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $question = Question::forToday();

        $players = Player::query()
            ->whereHas('qotd')
            // where has an incoming message from the player in the last 24 hours
            ->whereHas('messages', function ($query) {
                $query
                    ->where('direction', MessageDirection::INCOMING)
                    ->where('created_at', '>', now()->subHours(24));
            })
            // where the last QOTD related message sent to the player was more than 23.5 hours ago
            ->whereDoesntHave('messages', function ($query) {
                $query
                    ->where('body->content', 'like', '%QOTD%')
                    ->where('direction', MessageDirection::OUTGOING)
                    ->where('created_at', '>', now()->subHours(23.5));
            })
            ->get();


        $this->info(sprintf('Found %d players to remind', $players->count()));
        foreach ($players as $index => $player) {
            $this->info(sprintf('[%d of %d] Checking player %s', $index + 1, $players->count(), $player->number));

            $todaysAttempt = $player->attempts()
                ->where('question_id', $question->id)
                ->first();

            if (is_null($todaysAttempt)) {
                $this->info('  - Has not attempted today, sending reminder...');
                // send reminder
                $this->sendTodaysGameReminder($player);
            } else {
                $this->info('  - Already attempted today, sending reminder to set a reminder...');
                $this->sendRemindMeReminder($player);
            }
        }
    }

    protected function sendTodaysGameReminder(Player $player): void
    {
        $nudge = $player->qotd->current_streak >= 21 ? "Don't break the streak! 🔥" : "Can you check all these boxes? 💪";

        $message = sprintf(
            "🔔 Time to play today's QOTD! \n\nCurrent streak: \n%s\n\n%s",
            $player->getQotdCurrentStreakString(),
            $nudge
        );

        (new SendMessageOnWhatsapp)($player, Message::INTERACTIVE_PREFIX . $message, [
            'type' => 'button',
            'action' => [
                'buttons' => [
                    [
                        'type' => 'reply',
                        'reply' => [
                            'id' => 'play_qotd',
                            'title' => 'PLAY QOTD',
                        ],
                    ],
                ],
            ]
        ]);
    }

    protected function sendRemindMeReminder(Player $player): void
    {
        $nudge = $player->qotd->current_streak >= 21 ? "Don't break the streak! 🔥" : "Can you check all these boxes? 💪";

        $message = sprintf(
            "Good job on playing today's QOTD! \n\nCurrent streak: \n%s\n\n%s\n\nWant me to remind you to play QOTD tomorrow to not lose your streak?",
            $player->getQotdCurrentStreakString(),
            $nudge
        );

        (new SendMessageOnWhatsapp)($player, Message::INTERACTIVE_PREFIX . $message, [
            'type' => 'button',
            'action' => [
                'buttons' => [
                    [
                        'type' => 'reply',
                        'reply' => [
                            'id' => 'remind_me_qotd',
                            'title' => 'REMIND ME',
                        ],
                    ],
                ],
            ]
        ]);
    }
}
