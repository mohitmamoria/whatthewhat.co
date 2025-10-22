<?php

namespace App\Actions\Gifting;

use App\Models\Gift;
use App\Models\GiftCode;
use Illuminate\Support\Str;

class CreateGiftCodes
{
    public function __invoke(Gift $gift)
    {
        $existingCodesCount = $gift->giftCodes()->count();
        $codesToCreate = $gift->quantity - $existingCodesCount;

        for ($i = 0; $i < $codesToCreate; $i++) {
            $gift->giftCodes()->create([
                'code' => $this->generateCode($gift->name),
            ]);
        }
    }

    protected function generateCode(string $prefix): string
    {
        do {
            $code = $prefix . strtoupper(substr(Str::ulid(), -8));
        } while (GiftCode::where('code', $code)->exists());

        return $code;
    }
}
