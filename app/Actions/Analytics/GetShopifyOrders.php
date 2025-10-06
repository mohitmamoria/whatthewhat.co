<?php

namespace App\Actions\Analytics;

use App\Models\Product;
use App\Services\Shopify\Shopify;

class GetShopifyOrders
{
    public function __invoke(): array
    {
        $product = Product::first();

        // sku:"SKU1" OR sku:"SKU2" OR sku:"SKU3"
        $query = $product->variants->pluck('sku')->map(function ($sku) {
            return sprintf('sku:"%s"', $sku);
        })->join(' OR ');

        $response = Shopify::admin()->call('admin/getOrders', ['query' => $query, 'after' => 'eyJsYXN0X2lkIjo2MjU2MDU3NjgwMDUxLCJsYXN0X3ZhbHVlIjoxNzU5Nzc5Mzc4MDAwfQ==']);

        dd($response);


        return [];
    }
}
