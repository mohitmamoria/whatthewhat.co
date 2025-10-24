<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Gamification\TransactionDirection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('wallet_id')
                    ->required()
                    ->numeric(),
                TextInput::make('idempotency_key'),
                Select::make('direction')
                    ->options(TransactionDirection::class)
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('reason')
                    ->required(),
                Textarea::make('meta')
                    ->label('Body')
                    ->rows(8)
                    ->afterStateHydrated(fn($component, $state) => $component->state(json_encode($state, JSON_PRETTY_PRINT)))
                    ->dehydrateStateUsing(fn($state) => json_decode($state, true))
                    ->rule('json'),
            ]);
    }
}
