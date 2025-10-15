<?php

namespace App\Console\Commands;

use App\Actions\RecordShopifyOrderForPlayer;
use App\Models\Product;
use App\Services\Shopify\Shopify;
use Illuminate\Console\Command;

class SyncOrdersFromShopify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-shopify-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Shopify orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();

        $this->info(sprintf('Syncing orders for %d products', $products->count()));
        foreach ($products as $product) {
            // sku:"SKU1" OR sku:"SKU2" OR sku:"SKU3"
            $query = $product->variants->pluck('sku')->map(function ($sku) {
                return sprintf('sku:"%s"', $sku);
            })->join(' OR ');

            $this->info(sprintf('Query: %s', $query));

            $page = 1;
            $after = null;
            do {
                $this->info(sprintf('Fetching page %d', $page++));

                $response = Shopify::admin()->call('admin/getOrders', ['query' => $query, 'after' => $after]);

                $total = data_get($response, 'orders.edges') ? count(data_get($response, 'orders.edges')) : 0;
                foreach (data_get($response, 'orders.edges') as $index => $order) {
                    $this->info(sprintf('Processing order [%d/%d]: %s', $index + 1, $total, data_get($order, 'node.id')));
                    (new RecordShopifyOrderForPlayer)($order['node']);
                }

                $after = data_get($response, 'orders.pageInfo.endCursor');
            } while (data_get($response, 'orders.pageInfo.hasNextPage'));
        }

        $this->info('All orders synced successfully.');
    }
}
