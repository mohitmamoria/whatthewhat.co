<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'gamification_balances';

    protected $fillable = [
        'owner_type',
        'owner_id',
        'balance',
        'lifetime_earned',
        'lifetime_spent',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
