<?php

namespace App\Http\Resources;

use App\Actions\Qotd\GetShareMessage;
use App\Models\Attempt;
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
            'is_timedout' => $this->is_timedout,
            'is_completed' => $this->is_completed,
            'time_left' => Attempt::TIME_PER_ATTEMPT,
            'correct_answer_index' => $this->when($this->is_completed, function () {
                foreach ($this->question->options as $index => $option) {
                    if ($option['is_correct']) {
                        return $index;
                    }
                }
            }),
            'share_message' => $this->when($this->is_completed, function () {
                return (new GetShareMessage)($this->resource);
            }),
            'question' => $this->whenLoaded('question', QuestionResource::make($this->question)),
        ];
    }
}
