<?php

namespace App\Models\Markbook;

trait UsesMarkbook
{
    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}
