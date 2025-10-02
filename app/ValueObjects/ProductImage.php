<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class ProductImage implements Arrayable, JsonSerializable
{
    public function __construct(
        public string $id,
        public string $src,
        public string $alt_text = '',
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'src' => $this->src,
            'altText' => $this->alt_text,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
