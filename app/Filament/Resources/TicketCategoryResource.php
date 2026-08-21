<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketCategoryResource\Pages;
use App\Models\TicketCategory;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketCategoryResource extends Resource
{
    protected static ?string $model = TicketCategory::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Kategori Tiket';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(50),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(50),
                Forms\Components\TextInput::make('base_price')->required()->numeric()->prefix('Rp'),
                Forms\Components\TextInput::make('quota')->required()->numeric(),
                Forms\Components\TextInput::make('icon')->required()->maxLength(20),
                Forms\Components\TagsInput::make('benefits')->required(),
                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\Toggle::make('is_streaming')
                    ->label('Tiket Streaming')
                    ->helperText('Aktifkan jika kategori ini adalah tiket streaming (online only)')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                \Filament\Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('name')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('base_price')
                        ->money('idr')
                        ->color('primary')
                        ->icon('heroicon-m-banknotes'),
                    Tables\Columns\TextColumn::make('quota')
                        ->formatStateUsing(fn ($state, $record) => $record->sold . ' / ' . $state . ' Terjual')
                        ->color('gray')
                        ->icon('heroicon-m-ticket'),
                    Tables\Columns\TextColumn::make('is_streaming')
                        ->formatStateUsing(fn ($state) => $state ? 'Streaming (Online)' : 'Offline (Venue)')
                        ->icon(fn ($state) => $state ? 'heroicon-m-video-camera' : 'heroicon-m-user-group')
                        ->color(fn ($state) => $state ? 'info' : 'gray'),
                    Tables\Columns\ToggleColumn::make('is_active'),
                ])->space(2),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicketCategories::route('/'),
        ];
    }
}
