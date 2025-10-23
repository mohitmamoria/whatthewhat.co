<?php

namespace App\Models;

use App\Actions\Gamification\ProcessTransactionsForAnActivity;
use App\Models\Gamification\Activity;
use App\Models\Gamification\ActivityType;
use App\Models\Gamification\HasGamification;
use App\Services\Idempotency\Idempotency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    use SoftDeletes, HasGamification;

    protected $fillable = ['name', 'number', 'referrer_code'];

    public function otps()
    {
        return $this->morphMany(Otp::class, 'authenticatable');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function giftsGiven()
    {
        return $this->hasMany(Gift::class, 'gifter_id');
    }

    public static function byReferrerCode(string $code)
    {
        return static::where('referrer_code', $code)->first();
    }

    public static function sync($name, $number): Player
    {
        return DB::transaction(function () use ($name, $number) {
            $player = static::updateOrCreate(
                ['number' => normalize_phone($number)],
                ['name' => $name]
            );

            if ($player->wasRecentlyCreated) {
                // Set a unique referrer code
                $player->referrer_code = get_unique_referrer_code($player);
                $player->save();

                // Set an empty balance account
                $player->wallet()->firstOrCreate();
            }

            return $player->fresh();
        });
    }

    public function acted(ActivityType $type, array $meta = [], ?Carbon $occuredAt = null): Activity
    {
        if ($occuredAt === null) {
            $occuredAt = now();
        }

        return DB::transaction(function () use ($type, $meta, $occuredAt) {
            $idempotencyKey = Idempotency::key($type->value, [...$meta, 'player_id' => $this->id]);

            $existing = Activity::where('idempotency_key', $idempotencyKey)->first();
            if ($existing) {
                return $existing;
            }

            $activity = $this->activities()->create([
                'idempotency_key' => $idempotencyKey,
                'type' => $type->value,
                'meta' => $meta,
                'occurred_at' => $occuredAt,
            ]);

            (new ProcessTransactionsForAnActivity)($activity);

            return $activity;
        });
    }
}
