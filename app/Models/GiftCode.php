<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GiftCode extends Model
{
    use SoftDeletes, HasUniqueName;

    const RESERVATION_LIMIT_MINUTES = 5;

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

    #[Scope]
    protected function ready(Builder $query): Builder
    {
        return $query
            ->whereNull('received_at')
            ->where(function ($query) {
                $query->whereNull('reserved_at')->orWhere('reserved_at', '<', now()->subMinutes(static::RESERVATION_LIMIT_MINUTES));
            });
    }

    #[Scope]
    protected function reserved(Builder $query): Builder
    {
        return $query
            ->whereNull('received_at')
            ->where(function ($query) {
                $query->whereNotNull('reserved_at')->where('reserved_at', '>=', now()->subMinutes(static::RESERVATION_LIMIT_MINUTES));
            });
    }

    #[Scope]
    protected function received(Builder $query): Builder
    {
        return $query->whereNotNull('received_at');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function receiver()
    {
        return $this->belongsTo(Player::class, 'receiver_id');
    }
}
