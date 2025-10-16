<?php

namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'gamification_transactions';

    protected $fillable = [
        'owner_type',
        'owner_id',
        'idempotency_key',
        'direction',
        'amount',
        'reason',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'direction' => TransactionDirection::class,
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
