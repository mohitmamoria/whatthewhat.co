<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class ProductImage implements Arrayable, JsonSerializable
{
    public string $id;
    public string $src;
    public string $alt_text;

    public function __construct(
        array $data,
    ) {
        $this->id = $data['id'];
        $this->src = $data['src'];
        $this->alt_text = $data['alt_text'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'src' => $this->src,
            'alt_text' => $this->alt_text,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
