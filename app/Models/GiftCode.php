<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GiftCode extends Model
{
    use SoftDeletes, HasUniqueName;

    protected $fillable = [
        'gift_id',
        'name',
        'code',
        'receiver_id',
        'meta',
        'reserved_at',
        'received_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'reserved_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function receiver()
    {
        return $this->belongsTo(Player::class, 'receiver_id');
    }
}
