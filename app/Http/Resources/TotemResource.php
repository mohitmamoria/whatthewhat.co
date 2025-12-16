<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TotemResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'pages' => $this->pages,
            'progress' => $this->whenLoaded('players', function () {
                return json_decode($this->players->first()->pivot->progress ?? '[]', true) ?? [];
            }),
            'is_collected' => $this->whenLoaded('players', function () {
                return ($this->players->first()->pivot->collected_at ?? null) ? true : false;
            }),
        ];
    }
}
