<?php

namespace App\Filament\Resources\PresalePeriods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PresalePeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                \Filament\Tables\Columns\Layout\Stack::make([
                    TextColumn::make('name')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable(),
                    TextColumn::make('badge')
                        ->badge()
                        ->color('warning')
                        ->searchable(),
                    TextColumn::make('discount')
                        ->formatStateUsing(fn ($state) => 'Diskon ' . $state . '%')
                        ->color('success')
                        ->icon('heroicon-m-receipt-percent'),
                    TextColumn::make('starts_at')
                        ->dateTime('d M Y, H:i')
                        ->icon('heroicon-m-calendar')
                        ->color('gray'),
                    TextColumn::make('ends_at')
                        ->dateTime('d M Y, H:i')
                        ->icon('heroicon-m-calendar')
                        ->color('gray'),
                    IconColumn::make('is_active')
                        ->boolean(),
                ])->space(2),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
