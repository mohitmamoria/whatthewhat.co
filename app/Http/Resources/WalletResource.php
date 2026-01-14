<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'balance' => $this->balance,
            'lifetime_earned' => $this->lifetime_earned,
            'lifetime_spent' => $this->lifetime_spent,
            'currency' => 'Curiosity Points',
            'currency_symbol' => 'CP',
        ];
    }
}
