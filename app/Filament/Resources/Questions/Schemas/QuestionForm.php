<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('asked_on')
                    ->required(),
                MarkdownEditor::make('body')
                    ->required()
                    ->columnSpanFull(),
                Repeater::make('options')
                    ->schema([
                        TextInput::make('body')->required(),
                        Toggle::make('is_correct')
                            ->inline(false)
                            ->required(),
                    ])
                    ->columns(2)
            ]);
    }
}
