<?php

namespace App\Models;

use App\Enums\GiftVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gift extends Model
{
    use SoftDeletes, HasUniqueName;

    protected $fillable = [
        'name',
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
}
