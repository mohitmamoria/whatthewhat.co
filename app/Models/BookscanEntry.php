<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookscanEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shopify_order_id',
        'vendor',
        'date',
        'sku',
        'quantity',
        'price',
        'shipping_pin_code',
        'is_received_gift',
    ];

    protected $casts = [
        'date' => 'date',
        'is_received_gift' => 'boolean',
    ];

    #[Scope]
    protected function nonGifted(Builder $query): Builder
    {
        return $query->where('is_received_gift', false);
    }
}
