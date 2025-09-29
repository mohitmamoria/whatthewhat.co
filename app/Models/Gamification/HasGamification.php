<?php

namespace App\Models\Gamification;

trait HasGamification
{
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'owner');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'owner');
    }
}
