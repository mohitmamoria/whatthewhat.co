<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use SoftDeletes;

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

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function credit(string $idempotencyKey, int $points, string $reason, array $meta = []): Transaction
    {
        return $this->transact($idempotencyKey, TransactionDirection::CREDIT, abs($points), $reason, $meta);
    }

    public function debit(string $idempotencyKey, int $points, string $reason, array $meta = []): Transaction
    {
        return $this->transact($idempotencyKey, TransactionDirection::DEBIT, abs($points), $reason, $meta);
    }

    protected function transact(string $idempotencyKey, TransactionDirection $direction, int $points, string $reason, array $meta = []): Transaction
    {
        return DB::transaction(function () use ($idempotencyKey, $direction, $points, $reason, $meta) {
            $existing = Transaction::where('idempotency_key', $idempotencyKey)->first();
            if ($existing) {
                return $existing;
            }

            $transaction = $this->transactions()->create([
                'idempotency_key' => $idempotencyKey,
                'direction' => $direction,
                'amount' => $points,
                'reason' => $reason,
                'meta' => $meta,
            ]);

            if ($direction === TransactionDirection::DEBIT) {
                $this->balance -= $points;
                $this->lifetime_spent += $points;
            } else if ($direction === TransactionDirection::CREDIT) {
                $this->balance += $points;
                $this->lifetime_earned += $points;
            }

            $this->save();

            return $transaction;
        });
    }
}
