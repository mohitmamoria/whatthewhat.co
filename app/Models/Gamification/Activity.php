<?php

namespace App\Models\Gamification;

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

    protected function owner()
    {
        return $this->morphTo();
    }
}
