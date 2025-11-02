<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = 'gamification_activities';

    protected $fillable = [
        'owner_type',
        'owner_id',
        'idempotency_key',
        'type',
        'meta',
        'occurred_at',
    ];

    protected $casts = [
        'type' => ActivityType::class,
        'meta' => 'array',
        'occurred_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    #[Scope]
    public function ofType(Builder $query, ActivityType $type)
    {
        return $query->where('type', $type);
    }
}
