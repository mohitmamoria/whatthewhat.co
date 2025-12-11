<?php

namespace App\Models;

use App\Actions\Gamification\ProcessTransactionsForAnActivity;
use App\Models\Gamification\Activity;
use App\Models\Gamification\ActivityType;
use App\Models\Gamification\HasGamification;
use App\Services\Idempotency\Idempotency;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    use SoftDeletes, HasGamification;

    const DEFAULT_NAME = 'Player';

    protected $fillable = ['name', 'number', 'referrer_code'];

    // We have passwordless (OTP) login. It ensures this doesn’t break:
    public function getAuthPassword()
    {
        // return an empty string so guards that expect a string don’t explode
        return '';
    }

    public function otps()
    {
        return $this->morphMany(Otp::class, 'authenticatable');
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function giftsGiven()
    {
        return $this->hasMany(Gift::class, 'gifter_id');
    }

    public function giftCodesReceived()
    {
        return $this->hasMany(GiftCode::class, 'receiver_id');
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function qotd(): HasOne
    {
        return $this->hasOne(QotdGame::class);
    }

    public function referredQotds(): HasMany
    {
        return $this->hasMany(QotdGame::class, 'referrer_id');
    }

    public function getQotdStreakString($days = 21, $pad = false)
    {
        $streak = [];
        $from = now()->subDays($days);
        if ($this->qotd->joined_on->greaterThan($from)) {
            $from = $this->qotd->joined_on;
        }

        for ($date = $from; $date->lessThanOrEqualTo(now()); $date->addDay()) {
            $attempted = $this->attempts()
                ->whereDate('created_at', $date->toDateString())
                ->exists();

            if ($attempted) {
                $streak[] = '✅';
            } else {
                $streak[] = '⬜️';
            }
        }

        if ($pad && count($streak) < $days) {
            $streak = array_merge($streak, array_fill(0, $days - count($streak), '⬜️'));
        }

        return implode('', $streak);
    }

    public static function byReferrerCode(string $code)
    {
        return static::where('referrer_code', $code)->first();
    }

    public static function sync($name, $number, $shouldOverride = false): Player
    {
        $number = normalize_phone($number);

        return DB::transaction(function () use ($name, $number, $shouldOverride) {
            $player = static::where('number', $number)->first();

            if (is_null($player)) {
                $player = static::updateOrCreate(
                    ['number' => $number],
                    ['name' => $name]
                );

                // Set a unique referrer code
                $player->referrer_code = get_unique_referrer_code($player);
                $player->save();

                // Set an empty balance account
                $player->wallet()->firstOrCreate();
            }

            if ($shouldOverride) {
                $player->name = $name;
                $player->save();
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

    public function directLoginUrlTo(?string $next = null)
    {
        return url()
            ->temporarySignedRoute('auth.player.login.direct', now()->addMinutes(10), [
                'player' => $this->referrer_code,
                'next' => $next
            ]);
    }

    public function comingSoonSubscriptions()
    {
        return $this->hasMany(ComingSoonSubscription::class);
    }
}
