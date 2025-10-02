<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class ProductVariant implements Arrayable, JsonSerializable
{
    public function __construct(
        public string $id,
        public string $title,
        public string $image_id,
        public string $image_src,
        public string $price,
        public string $sku,
        public bool $is_available,
        public int $inventory_left,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_id' => $this->image_id,
            'image_src' => $this->image_src,
            'price' => $this->price,
            'sku' => $this->sku,
            'is_available' => $this->is_available,
            'inventory_left' => $this->inventory_left,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
