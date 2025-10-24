<?php

namespace App\Filament\Resources\Wallets\Schemas;

use App\Models\Player;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MorphToSelect::make('owner')
                    ->types([
                        MorphToSelect\Type::make(Player::class)
                            ->titleAttribute('number'),
                    ])
                    ->required(),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('lifetime_earned')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('lifetime_spent')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
