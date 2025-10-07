<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
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

        $first = ["919820520328", "919354844109", "919389865494", "917310101734", "919229494507", "918840554374", "918983966924", "917983464591", "919758427680", "919667583084", "917218822599", "917028255856", "918898600000", "919644048072", "919654181959", "918447793605", "919432928330", "919497264180", "917896746708", "918830184837", "916361366994", "919390685082", "919899900348", "919315256699", "918073957233", "919725149588", "918218060309", "918866163841", "917092668488", "917016535455", "918737829192", "31619666517", "918791443103", "919711197577", "919595588762", "18134534466", "919969867372", "916353082090", "918527770422", "918447265257", "918527161990", "919113311350", "919167766189", "919900940316", "917028280676", "919739061640", "917995162604", "919560093084", "916356800080", "917347594452", "918308667787", "918369940348", "917302839102", "919152469478", "917598448160", "919632940280", "918810291301", "918909766190", "917359155865", "917425853532", "917299077299", "919392966185", "919405429583", "917559244971", "919949479535", "919700015755", "918758748797", "919988739819", "919468391552", "919033319106", "919665184955", "919940627899", "918826079503", "919659600060", "918762945136", "919980135853", "917902138010", "919611540410", "919029917002", "918310309620", "919492848849", "918638683579", "918320660388", "918446089278", "918780146905", "919262234580", "919285534249", "919883629587", "917572826402", "918895341365", "917709914748", "919834645651", "919467986993", "919607589550", "919479521081", "919354136946", "919641459210", "917397918047", "919566188247", "919956117608"];

        $players = Player::whereIn('number', $first)->whereDoesntHave('messages', function ($query) use ($message) {
            $query->where('body->content', $message);
        })->get();

        foreach ($players as $player) {
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
