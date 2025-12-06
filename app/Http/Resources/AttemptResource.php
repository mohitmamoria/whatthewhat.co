<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttemptResource extends JsonResource
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
            'answer' => $this->answer,
            'is_correct' => $this->is_correct,
            'time_spent' => $this->time_spent,
            'question' => $this->whenLoaded('question', QuestionResource::make($this->question)),
        ];
    }
}
