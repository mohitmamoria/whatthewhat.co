<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QotdGameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'longest_streak' => $this->longest_streak,
            'current_streak' => $this->current_streak,
            'total_attempted' => $this->total_attempted,
            'total_answered' => $this->total_answered,
            'answered_percent' => number_format($this->answered_percent, 2),
            'average_time_taken' => number_format($this->average_time_taken, 2),
        ];
    }
}
