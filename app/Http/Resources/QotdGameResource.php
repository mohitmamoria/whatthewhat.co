<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'is_expired' => $this->is_expired,
            'longest_streak' => sprintf('%d %s', $this->longest_streak, Str::plural('day', $this->longest_streak)),
            'current_streak' => sprintf('%d %s', $this->current_streak, Str::plural('day', $this->current_streak)),
            'total_attempted' => $this->total_attempted,
            'total_answered' => $this->total_answered,
            'answered_percent' => sprintf('%s%%', number_format($this->answered_percent, 2)),
            'average_time_taken' => sprintf('%ss', number_format($this->average_time_taken, 2)),
        ];
    }
}
