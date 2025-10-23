<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otp extends Model
{
    use SoftDeletes;

    const EXPIRY_MINUTES = 10;

    protected $fillable = [
        'authenticatable_type',
        'authenticatable_id',
        'code',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function authenticatable()
    {
        return $this->morphTo();
    }

    #[Scope]
    public function unused(Builder $query): Builder
    {
        return $query->whereNull('used_at');
    }

    #[Scope]
    public function unexpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }

    public function markAsUsed(): void
    {
        $this->used_at = now();
        $this->save();
    }
}
