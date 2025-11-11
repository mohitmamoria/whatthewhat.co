<?php

namespace App\Http\Resources\Markbook;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'authors' => $this->authors,
            'cover_image_url' => $this->cover_image_url,
            'published_year' => $this->published_year,
        ];
    }
}
