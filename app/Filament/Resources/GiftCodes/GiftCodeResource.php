<?php

namespace App\Filament\Resources\GiftCodes;

use App\Filament\Resources\GiftCodes\Pages\CreateGiftCode;
use App\Filament\Resources\GiftCodes\Pages\EditGiftCode;
use App\Filament\Resources\GiftCodes\Pages\ListGiftCodes;
use App\Filament\Resources\GiftCodes\Schemas\GiftCodeForm;
use App\Filament\Resources\GiftCodes\Tables\GiftCodesTable;
use App\Models\GiftCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GiftCodeResource extends Resource
{
    protected static ?int $navigationSort = 50;

    protected static ?string $model = GiftCode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCodeBracketSquare;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return GiftCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GiftCodesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGiftCodes::route('/'),
            'create' => CreateGiftCode::route('/create'),
            'edit' => EditGiftCode::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
