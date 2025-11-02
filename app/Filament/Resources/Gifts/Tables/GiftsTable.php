<?php

namespace App\Filament\Resources\Gifts\Tables;

use App\Http\Resources\PlayerResource;
use App\Filament\Resources\Players\PlayerResource as FilamentPlayerResource;
use App\Models\Player;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\RichEditor\TextColor;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GiftsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('gifter.name')
                    ->label('Gifter')
                    ->color('primary')
                    ->url(function ($record) {
                        $gifter = $record->gifter;
                        if (! $gifter instanceof Player) {
                            return null;
                        }
                        return FilamentPlayerResource::getUrl('edit', ['record' => $gifter]);
                    }),
                TextColumn::make('shopify_order_id')
                    ->searchable(),
                TextColumn::make('value_per_code')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_shipping_covered')->boolean(),
                TextColumn::make('ready_codes_count')
                    ->label('Available codes')->badge(),
                ToggleColumn::make('is_available_for_all'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
