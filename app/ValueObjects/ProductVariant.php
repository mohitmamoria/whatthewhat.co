<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class ProductVariant implements Arrayable, JsonSerializable
{
    public string $id;
    public string $title;
    public ?string $image_id;
    public ?string $image_src;
    public ?string $description;
    public float $price;
    public string $sku;
    public bool $is_available;
    public int $inventory_left;

    public function __construct(
        array $data,
    ) {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->image_id = $data['image_id'];
        $this->image_src = $data['image_src'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->sku = $data['sku'];
        $this->is_available = $data['is_available'];
        $this->inventory_left = $data['inventory_left'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_id' => $this->image_id,
            'image_src' => $this->image_src,
            'description' => $this->description,
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
