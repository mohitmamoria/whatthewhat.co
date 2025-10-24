<?php

namespace App\Filament\Resources\GiftCodes\Pages;

use App\Filament\Resources\GiftCodes\GiftCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGiftCodes extends ListRecords
{
    protected static string $resource = GiftCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
