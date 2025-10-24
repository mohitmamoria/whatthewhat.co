<?php

namespace App\Filament\Resources\Messages\Schemas;

use App\Enums\MessageDirection;
use App\Enums\MessagePlatform;
use App\Enums\MessageStatus;
use Filament\Forms\Components\Select;
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
                TextInput::make('body')
                    ->required(),
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
