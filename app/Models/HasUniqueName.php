<?php

namespace App\Models;

use Illuminate\Support\Str;

trait HasUniqueName
{
    public static function bootHasUniqueName()
    {
        static::creating(function ($model) {
            if (empty($model->name)) {
                $model->name = static::generateUniqueName();
            }
        });
    }

    protected static function generateUniqueName()
    {
        do {
            $name = strtoupper(substr(Str::ulid(), -8));
        } while (static::where('name', $name)->exists());

        return $name;
    }
}
