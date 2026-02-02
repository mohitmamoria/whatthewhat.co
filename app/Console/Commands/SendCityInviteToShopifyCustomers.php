<?php

namespace App\Console\Commands;

use App\Actions\SendMessageOnWhatsapp;
use App\Models\Message;
use App\Models\Player;
use App\Services\Shopify\Shopify;
use Illuminate\Console\Command;

class SendCityInviteToShopifyCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:city-invite {city} {ids}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send city invites to Shopify customers based on provided Shopify customer IDs';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Shopify::admin()->call('admin/getCustomers', [
            'query' => collect(
                str($this->argument('ids'))->explode(',')->toArray()
            )
                ->map(fn($id) => 'id:' . $id)
                ->join(' OR ')
        ]);

        $customers = collect(data_get($response, 'customers.nodes', []));

        $this->info(sprintf('Found %d players to remind', $customers->count()));
        foreach ($customers as $index => $customer) {
            $player = Player::sync('Player', data_get($customer, 'phone'));

            $this->info(sprintf('[%d of %d] Sending to player %s', $index + 1, $customers->count(), $player->number));

            $messageModel = (new SendMessageOnWhatsapp)($player, Message::TEMPLATE_PREFIX . 'wian_city_notice', [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $this->argument('city'),
                        ],
                    ],
                ],
                [
                    "type" => "button",
                    "sub_type" => "url",
                    "index" => 0,
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => 'wian-kolkata-feb-8', // this will be applied after aph.to/<here> by Meta
                        ],
                    ],
                ],
            ]);
        }
    }
}
