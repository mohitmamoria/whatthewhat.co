<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Gamification\TransactionDirection;
use Filament\Forms\Components\Select;
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
                TextInput::make('meta'),
            ]);
    }
}
