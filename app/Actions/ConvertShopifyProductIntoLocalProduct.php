<?php

namespace App\Actions;

use App\Actions\Action;
use App\Models\Gamification\Activity;
use App\Models\Gamification\Transaction;
use App\Models\Product;
use App\Services\Idempotency\Idempotency;
use App\Services\Shopify\ShopifyRichText;
use App\ValueObjects\ProductImage;
use App\ValueObjects\ProductVariant;

class ConvertShopifyProductIntoLocalProduct
{
    public function __invoke(array $shopifyProduct): array
    {
        $variants = collect(data_get($shopifyProduct, 'product.variants.edges', []))->map(function ($variant) {
            return new ProductVariant([
                'id' => data_get($variant, 'node.id'),
                'title' => data_get($variant, 'node.title'),
                'image_id' => data_get($variant, 'node.image.id'),
                'image_src' => data_get($variant, 'node.image.url'),
                'description' => ShopifyRichText::render(data_get($variant, 'node.variantDescription.value')),
                'sku' => data_get($variant, 'node.sku'),
                'price' => data_get($variant, 'node.price'),
                'is_available' => data_get($variant, 'node.availableForSale', false),
                'inventory_left' => data_get($variant, 'node.inventoryQuantity', 0),
            ]);
        });

        $images = collect(data_get($shopifyProduct, 'product.images.edges', []))
            ->reject(function ($image) use ($variants) {
                // reject image if its ID exists in the variants images
                return in_array(data_get($image, 'node.id'), $variants->pluck('image_id')->toArray());
            })
            ->map(function ($image) {
                return new ProductImage([
                    'id' => data_get($image, 'node.id'),
                    'src' => data_get($image, 'node.src'),
                    'alt_text' => data_get($image, 'node.altText'),
                ]);
            });

        $product = [
            'title' => data_get($shopifyProduct, 'product.title'),
            'description_text' => data_get($shopifyProduct, 'product.description'),
            'description_html' => data_get($shopifyProduct, 'product.descriptionHtml'),
            'variants' => $variants,
            'images' => $images,
        ];

        return $product;
    }
}
