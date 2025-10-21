<?php

namespace App\Models;

use App\ValueObjects\ProductImage;
use App\ValueObjects\ProductVariant;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shopify_id',
        'title',
        'description_text',
        'description_html',
        'variants',
        'images',
    ];

    protected function casts(): array
    {
        return  [
            'variants' => AsCollection::of(ProductVariant::class),
            'images' => AsCollection::of(ProductImage::class),
        ];
    }

    public static function byShopifyId(string $shopifyId): ?self
    {
        return self::where('shopify_id', 'gid://shopify/Product/' . $shopifyId)->first();
    }

    public static function byVariantShopifyId(string $variantShopifyId): ?self
    {
        return self::whereRaw(
            "JSON_SEARCH(JSON_EXTRACT(`variants`, '$[*].id'), 'one', ?) IS NOT NULL",
            [$variantShopifyId]
        )->first();
    }
}
