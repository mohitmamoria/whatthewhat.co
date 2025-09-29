<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'gamification_wallets';

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
