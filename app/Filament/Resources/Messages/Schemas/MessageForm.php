<?php

namespace App\Filament\Resources\Messages\Schemas;

use App\Enums\MessageDirection;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('player_id')
                    ->required()
                    ->numeric(),
                Select::make('platform')
                    ->options(MessagePlatform::class)
                    ->required(),
                TextInput::make('platform_message_id')
                    ->required(),
                Textarea::make('body')
                    ->label('Body')
                    ->rows(8)
                    ->afterStateHydrated(fn($component, $state) => $component->state(json_encode($state, JSON_PRETTY_PRINT)))
                    ->dehydrateStateUsing(fn($state) => json_decode($state, true))
                    ->required()
                    ->rule('json'),
                Select::make('direction')
                    ->options(MessageDirection::class)
                    ->required(),
                Select::make('status')
                    ->options(MessageStatus::class)
                    ->default('sent')
                    ->required(),
            ]);
    }
}
