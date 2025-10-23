<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gift extends Model
{
    use SoftDeletes, HasUniqueName;

    const VALUE_OF_BOOK = 399;

    protected $fillable = [
        'name',
        'shopify_order_id',
        'value_per_code',
        'quantity',
    ];

    public function gifter()
    {
        return $this->belongsTo(Player::class, 'gifter_id');
    }

    public function giftCodes()
    {
        return $this->hasMany(GiftCode::class);
    }

    public function isShippingCovered(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->value_per_code > static::VALUE_OF_BOOK,
        );
    }
}
