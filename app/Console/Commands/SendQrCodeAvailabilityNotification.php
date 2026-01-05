<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
use App\Models\ComingSoonSubscription;
use App\Models\Message;
use Illuminate\Console\Command;

class SendQrCodeAvailabilityNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:qr-available {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification when a QR code becomes available for a specific page';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $template = Message::TEMPLATE_PREFIX . 'qr_code_now_available';

        $page = $this->argument('page');

        [$name, $url] = $this->getPageNameAndUrl($page);

        $this->info(sprintf('Notifying subscribers about QR code availability for %s (%s)', $name, $url));

        $subscriptions = ComingSoonSubscription::with('player')
            ->where('page', $page)
            ->get();

        $this->info(sprintf('Found %d subscriptions', $subscriptions->count()));
        foreach ($subscriptions as $index => $subscription) {
            $player = $subscription->player;
            $this->info(sprintf(
                '[%d of %d] Notifying Player:: %d: %s (%s)',
                $index + 1,
                $subscriptions->count(),
                $player->id,
                $player->name,
                $player->number,
            ));

            $messageModel = (new SendMessageOnWhatsapp)($player, $template, [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $name,
                        ],
                        [
                            "type" => "text",
                            "text" => $url,
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

    private function getPageNameAndUrl(string $page): array
    {
        return match ($page) {
            'play-along' => ['Play Along (Map)', 'https://wtw.is/book/play-along'],
            'markbook' => ['Markbook', 'https://wtw.is/markbook'],
            'totems' => ['Totems', 'https://wtw.is/book/totems'],
            'refer' => ['Mount Pyr (Bonus Section)', 'https://wtw.is/book/refer'],
            default => throw new \InvalidArgumentException("Unknown page: $page"),
        };
    }
}
