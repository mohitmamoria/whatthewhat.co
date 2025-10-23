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
        return [
            'name' => $this->name,
            'gifter' => PlayerResource::make($this->gifter),
            'is_shipping_covered' => $this->is_shipping_covered,
            'quantity' => $this->quantity,
        ];
    }
}
