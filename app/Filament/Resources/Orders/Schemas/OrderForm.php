<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['sm' => 1, 'md' => 2])
            ->components([
                TextInput::make('ticket_code')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('whatsapp')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('ticket_category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('presale_period_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('payment_status')
                    ->required()
                    ->default('pending'),
                TextInput::make('xendit_invoice_id'),
                Textarea::make('xendit_invoice_url')
                    ->columnSpanFull(),
                TextInput::make('xendit_payment_method'),
                DateTimePicker::make('payment_confirmed_at'),
                TextInput::make('scan_status')
                    ->required()
                    ->default('unused'),
                DateTimePicker::make('scanned_at'),
                Toggle::make('wa_sent')
                    ->required(),
                DateTimePicker::make('wa_sent_at'),
                Toggle::make('email_sent')
                    ->required(),
                DateTimePicker::make('email_sent_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('ordered_at')
                    ->required(),
            ]);
    }
}
