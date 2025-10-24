<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('shopify_id')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description_text')
                    ->columnSpanFull(),
                Textarea::make('description_html')
                    ->columnSpanFull(),
                Textarea::make('variants')
                    ->rows(8)
                    ->afterStateHydrated(fn($component, $state) => $component->state(json_encode($state, JSON_PRETTY_PRINT)))
                    ->dehydrateStateUsing(fn($state) => json_decode($state, true))
                    ->required()
                    ->rule('json'),
                Textarea::make('images')
                    ->rows(8)
                    ->afterStateHydrated(fn($component, $state) => $component->state(json_encode($state, JSON_PRETTY_PRINT)))
                    ->dehydrateStateUsing(fn($state) => json_decode($state, true))
                    ->required()
                    ->rule('json'),
            ]);
    }
}
