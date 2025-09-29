<?php

namespace App\Models\Gamification;

trait HasGamification
{
    public function balance()
    {
        return $this->morphOne(Balance::class, 'owner');
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
