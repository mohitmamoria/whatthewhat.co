<?php

namespace App\Filament\Resources\GiftCodes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GiftCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('gift_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('receiver_id')
                    ->numeric(),
                Textarea::make('meta')
                    ->rows(8)
                    ->afterStateHydrated(fn($component, $state) => $component->state(json_encode($state, JSON_PRETTY_PRINT)))
                    ->dehydrateStateUsing(fn($state) => json_decode($state, true))
                    ->rule('json'),
                DateTimePicker::make('reserved_at'),
                DateTimePicker::make('received_at'),
            ]);
    }
}
