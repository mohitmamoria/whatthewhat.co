<?php

namespace App\Filament\Resources\Players\RelationManagers;

use App\Filament\Resources\Gifts\GiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class GiftsGivenRelationManager extends RelationManager
{
    protected static string $relationship = 'giftsGiven';

    protected static ?string $relatedResource = GiftResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
