<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Models\Gamification\ActivityType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('owner_type')
                    ->required(),
                TextInput::make('owner_id')
                    ->required()
                    ->numeric(),
                TextInput::make('idempotency_key'),
                Select::make('type')
                    ->options(ActivityType::class)
                    ->required(),
                TextInput::make('meta'),
                DateTimePicker::make('occurred_at')
                    ->required(),
            ]);
    }
}
