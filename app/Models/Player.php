<?php

namespace App\Models;

use App\Models\Gamification\HasGamification;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasGamification;

    protected $fillable = ['name', 'number'];

    public static function sync($name, $number)
    {
        static::upsert([
            [
                'name' => $name,
                'number' => $number,
                'referrer_code' => get_unique_referrer_code(new static(compact('name', 'number')))
            ],
        ], ['number'], ['name']);
    }
}
