<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('number')
                    ->required(),
                TextInput::make('referrer_code'),
                DateTimePicker::make('unsubscribed_at'),
            ]);
    }
}
