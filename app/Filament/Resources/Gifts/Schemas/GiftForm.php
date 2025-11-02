<?php

namespace App\Filament\Resources\Gifts\Schemas;

use App\Models\Player;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('gifter')
                    ->required()
                    ->relationship('gifter', 'name')
                    ->searchable(['name', 'number'])
                    ->preload(),
                TextInput::make('gifter_name')->nullable(),
                TextInput::make('shopify_order_id')
                    ->required(),
                TextInput::make('value_per_code')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Toggle::make('is_available_for_all'),
            ]);
    }
}
