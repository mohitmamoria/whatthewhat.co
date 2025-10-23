<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $player = $request->user('player');

        return [
            'name' => $this->name,
            'gifter' => PlayerResource::make($this->gifter),
            'is_shipping_covered' => $this->is_shipping_covered,
            'total_count' => $this->quantity,
            'ready_count' => $this->giftCodes()->ready()->count(),
            'reserved_count' => $this->giftCodes()->reserved()->count(),
            'received_count' => $this->giftCodes()->received()->count(),
            'has_received_gift' => $player ? $player->giftCodesReceived()->count() > 0 : false,
        ];
    }
}
