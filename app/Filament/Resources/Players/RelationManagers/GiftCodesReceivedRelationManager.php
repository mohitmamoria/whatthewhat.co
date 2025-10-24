<?php

namespace App\Filament\Resources\Players\RelationManagers;

use App\Filament\Resources\GiftCodes\GiftCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class GiftCodesReceivedRelationManager extends RelationManager
{
    protected static string $relationship = 'giftCodesReceived';

    protected static ?string $relatedResource = GiftCodeResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
