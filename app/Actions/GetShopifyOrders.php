<?php

namespace App\Actions;

use App\Models\Player;
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

        $processed = [];
        $after = null;
        do {
            $response = Shopify::admin()->call('admin/getOrders', ['query' => $query, 'after' => $after]);

            foreach (data_get($response, 'orders.edges') as $order) {
                $processed[] = $this->process($order['node']);
            }

            $after = data_get($response, 'orders.pageInfo.endCursor');
        } while (data_get($response, 'orders.pageInfo.hasNextPage'));

        dd($processed);


        return [];
    }

    protected function process(array $order)
    {
        $attributes = data_get($order, 'customAttributes');

        $ref = collect($attributes)->where('key', 'ref')->first()['value'];

        $referrer = Player::byReferrerCode($ref);

        return [
            data_get($order, 'customer.displayName'),
            data_get($order, 'customer.defaultAddress.phone'),
            $referrer?->name,
            '+' . $referrer?->number,
        ];
    }
}
