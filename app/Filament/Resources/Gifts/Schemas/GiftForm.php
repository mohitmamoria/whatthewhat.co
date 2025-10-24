<?php

namespace App\Filament\Resources\Gifts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('gifter_id')
                    ->required()
                    ->numeric(),
                TextInput::make('shopify_order_id')
                    ->required(),
                TextInput::make('value_per_code')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
            ]);
    }
}
