<?php

namespace App\Models;

use App\ValueObjects\ProductImage;
use App\ValueObjects\ProductVariant;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
}
