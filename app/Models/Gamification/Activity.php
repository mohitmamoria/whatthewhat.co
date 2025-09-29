<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'gamification_activities';

    protected $fillable = [
        'owner_type',
        'owner_id',
        'idempotency_key',
        'type',
        'data',
        'occurred_at',
    ];

    protected $casts = [
        'data' => 'array',
        'occurred_at' => 'datetime',
    ];

    protected function owner()
    {
        return $this->morphTo();
    }
}
