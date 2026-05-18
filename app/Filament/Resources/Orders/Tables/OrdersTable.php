<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
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
                    TextColumn::make('nama')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable(),
                    TextColumn::make('ticket_code')
                        ->color('primary')
                        ->icon('heroicon-m-ticket')
                        ->searchable(),
                    TextColumn::make('payment_status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'confirmed' => 'success',
                            'pending' => 'warning',
                            'failed' => 'danger',
                            default => 'gray',
                        })
                        ->searchable(),
                    TextColumn::make('quantity')
                        ->formatStateUsing(fn ($state) => $state . ' Tiket')
                        ->icon('heroicon-m-users')
                        ->color('gray'),
                    TextColumn::make('total_price')
                        ->money('IDR')
                        ->icon('heroicon-m-banknotes')
                        ->color('gray'),
                    TextColumn::make('whatsapp')
                        ->icon('heroicon-m-phone')
                        ->color('gray')
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])->space(2),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
