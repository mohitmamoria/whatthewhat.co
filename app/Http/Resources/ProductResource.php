<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'description_text' => $this->description_text,
            'description_html' => $this->description_html,
            'variants' => collect($this->variants)->select(['id', 'title', 'image_src', 'description', 'price', 'sku', 'is_available'])->toArray(),
            'images' => collect($this->images)->select(['src', 'alt_text'])->toArray(),
        ];
    }
}
