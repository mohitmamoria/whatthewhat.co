<?php

namespace App\Console\Commands;

use App\Enums\MessagePlatform;
use App\Models\Message;
use App\Models\Player;
use Illuminate\Console\Command;

class SendMessageToPlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-message {player : The ID of the player}  {message : The message to send} {platform=whatsapp : The platform on which the message has to be sent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the given message to the user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $player = Player::find($this->argument('player'));

        if (is_null($player)) {
            $this->error('ERROR: Player not found.');
            return 1;
        }

        $message = $this->argument('message');
        $platform = $this->argument('platform');

        $validPlatforms = collect(MessagePlatform::cases())->pluck('value');
        if ($validPlatforms->doesntContain($platform)) {
            $this->error(sprintf('ERROR: Invalid platform. Supported platforms are %s.', $validPlatforms->join(', ')));
            return 1;
        }
    }
}
