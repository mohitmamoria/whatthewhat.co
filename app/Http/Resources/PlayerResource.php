<?php

namespace App\Http\Resources;

use App\Actions\Qotd\GetReferralMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => normalize_text($this->name),
            'number' => obfuscate_phone($this->number),
            'wallet' => WalletResource::make($this->wallet),
            'qotd_referral_message_html' => nl2br((new GetReferralMessage)($this->resource)),
            'qotd_referral_message' => (new GetReferralMessage)($this->resource),
        ];
    }
}
