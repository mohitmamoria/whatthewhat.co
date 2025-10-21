<?php

namespace App\Console\Commands;

use App\Actions\ConvertShopifyProductIntoLocalProduct;
use App\Models\Product;
use App\Services\Shopify\Shopify;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncProductsFromShopify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-shopify-products {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest products from Shopify and sync with local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ids = [
            env('SHOPIFY_WTW_PRODUCT_ID'),
            env('SHOPIFY_WTW_GIFT_PRODUCT_ID'),
        ];

        if ($this->option('id')) {
            $ids = [$this->option('id')];
        }

        foreach ($ids as $id) {
            $this->info(sprintf("Syncing product with ID: %s", $id));

            $response = Shopify::admin()->call('admin/getProduct', ['id' => 'gid://shopify/Product/' . $id]);

            $product = (new ConvertShopifyProductIntoLocalProduct)($response);
            $product = DB::transaction(function () use ($response, $product) {
                return Product::updateOrCreate(
                    ['shopify_id' => data_get($response, 'product.id')],
                    $product,
                );
            });
        }

        $this->info('Success!');
    }
}
