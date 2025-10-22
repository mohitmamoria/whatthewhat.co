<?php

namespace App\Actions\Gifting;

use App\Models\Gift;
use App\Models\GiftCode;
use Illuminate\Support\Facades\DB;

class ReserveGiftCode
{
    public function __invoke(Gift $gift): ?GiftCode
    {
        return DB::transaction(function () use ($gift) {
            $giftCode = $gift->giftCodes()->ready()
                ->lockForUpdate()
                ->first();

            if ($giftCode) {
                $giftCode->update(['reserved_at' => now()]);
            }

            return $giftCode;
        });
    }
}
