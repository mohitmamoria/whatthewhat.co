<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'number'];

    public static function sync($name, $number)
    {
        static::upsert([
            ['name' => $name, 'number' => $number],
        ], ['number'], ['name']);
    }
}
