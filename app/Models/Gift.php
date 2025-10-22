<?php

namespace App\Models;

use App\Enums\GiftVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'variant',
        'quantity',
    ];

    protected $casts = [
        'variant' => GiftVariant::class,
    ];

    public function gifter()
    {
        return $this->belongsTo(Player::class, 'gifter_id');
    }
}
