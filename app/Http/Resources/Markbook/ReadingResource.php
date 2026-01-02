<?php

namespace App\Http\Resources\Markbook;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReadingResource extends JsonResource
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
            'pages_read' => $this->pages_read,
            'notes' => $this->notes,
            'created_at' => $this->created_at->toDayDateTimeString(),
        ];
    }
}
