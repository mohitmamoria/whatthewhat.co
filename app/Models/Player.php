<?php

namespace App\Models;

use App\Models\Gamification\HasGamification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    use HasGamification;

    protected $fillable = ['name', 'number', 'referrer_code'];

    public static function sync($name, $number)
    {
        DB::transaction(function () use ($name, $number) {
            $player = static::updateOrCreate(
                ['number' => $number],
                ['name' => $name]
            );

            if ($player->wasRecentlyCreated) {
                // Set a unique referrer code
                $player->referrer_code = get_unique_referrer_code($player);
                $player->save();

                // Set an empty balance account
                $player->balance()->firstOrCreate();
            }
        });
    }
}
