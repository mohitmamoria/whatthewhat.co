<?php

namespace App\Actions\Gamification;

use App\Actions\Action;
use App\Models\Gamification\Activity;
use App\Models\Gamification\Transaction;
use App\Services\Idempotency\Idempotency;

class ProcessTransactionsForAnActivity
{
    public function __invoke(Activity $activity): array
    {
        $owner = $activity->owner;

        $idempotencyKey = Idempotency::key('activity_processed', [
            'activity_id' => $activity->id,
        ]);

        $transactions = [];

        $method = null;
        if ($activity->type->points() > 0) {
            $method = 'credit';
        } else if ($activity->type->points() < 0) {
            $method = 'debit';
        }

        if ($method) {
            $transactions[] = $owner->wallet->$method(
                idempotencyKey: $idempotencyKey,
                points: $activity->type->points(),
                reason: $activity->type->label(),
                meta: [...$activity->meta, 'activity_id' => $activity->id, 'owner_type' => $owner->getMorphClass(), 'owner_id' => $owner->getKey()],
            );
        }

        return $transactions;
    }
}
