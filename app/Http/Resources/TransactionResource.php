<?php

namespace App\Http\Resources;

use App\Models\Gamification\Activity;
use App\Models\Player;
use App\Models\Question;
use App\Models\Totem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'direction' => $this->direction,
            'reason' => $this->reason,
            'meta_for_human' => $this->whenLoaded('activity', function () {
                return $this->metaForHuman();
            }),
            'created_at' => $this->created_at->toFormattedDateString(),
        ];
    }

    protected function metaForHuman(): ?string
    {
        $method = str($this->activity->type->value)->camel()->toString();

        if (method_exists($this, $method)) {
            return $this->{$method}($this->activity);
        }

        return null;
    }

    protected function qotdReferred(Activity $activity): string
    {
        return sprintf(
            'Shared QOTD with: %s',
            obfuscate_phone(Player::find($activity->meta['referred_player_id'])?->number),
        );
    }

    protected function totemCollected(Activity $activity): string
    {
        return sprintf(
            '%s',
            Totem::find($activity->meta['totem_id'])?->name,
        );
    }
}
