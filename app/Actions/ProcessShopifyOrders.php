<?php

namespace App\Actions;

use App\Models\Player;
use App\Models\Product;
use App\Services\Shopify\Shopify;

class ProcessShopifyOrders
{
    public function __invoke(callable $action)
    {
        $products = Product::all();

        foreach ($products as $product) {
            // sku:"SKU1" OR sku:"SKU2" OR sku:"SKU3"
            $query = $product->variants->pluck('sku')->map(function ($sku) {
                return sprintf('sku:"%s"', $sku);
            })->join(' OR ');

            $after = null;
            do {
                $response = Shopify::admin()->call('admin/getOrders', ['query' => $query, 'after' => $after]);

                foreach (data_get($response, 'orders.edges') as $order) {
                    $action($order);
                }

                $after = data_get($response, 'orders.pageInfo.endCursor');

                sleep(1); // To avoid rate limiting
            } while (data_get($response, 'orders.pageInfo.hasNextPage'));
        }
    }
}
