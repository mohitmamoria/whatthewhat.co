<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Models\Gamification\ActivityType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
                Textarea::make('meta')
                    ->label('Meta')
                    ->rows(8)
                    ->afterStateHydrated(fn($component, $state) => $component->state(json_encode($state, JSON_PRETTY_PRINT)))
                    ->dehydrateStateUsing(fn($state) => json_decode($state, true))
                    ->rule('json'),
                DateTimePicker::make('occurred_at')
                    ->required(),
            ]);
    }
}
