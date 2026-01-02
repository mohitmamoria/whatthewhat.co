<?php

namespace App\Actions\Totems;

use App\Models\Gamification\ActivityType;
use App\Models\Player;
use App\Models\Totem;
use Illuminate\Support\Facades\DB;

class MarkTotemAsCollected
{
    public function __invoke(Player $player, Totem $totem): void
    {
        $existing = $player->totems()->where('totem_id', $totem->id)->first();
        if (!$existing) {
            return;
        }

        $progress = json_decode($existing->pivot->progress, true) ?? [];

        if (collect($progress)->sort()->values()->all() !== collect($totem->pages)->sort()->values()->all()) {
            return;
        }

        DB::transaction(function () use ($player, $totem) {
            $player->totems()->updateExistingPivot($totem->id, [
                'collected_at' => now(),
            ]);

            $player->acted(ActivityType::TOTEM_COLLECTED, [
                'totem_id' => $totem->id,
            ]);
        });
    }
}
