<?php

namespace App\Services\Shopify;

use Exception;

class ShopifyException extends Exception
{
    public array $context;

    public function __construct(string $message, int $code = 0, array $context = [])
    {
        parent::__construct($message, $code);
        $this->context = $context;
    }

    public function context(): array
    {
        return $this->context;
    }
}
