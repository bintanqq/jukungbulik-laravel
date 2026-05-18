<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ticket_code'),
                TextEntry::make('nama'),
                TextEntry::make('whatsapp'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('ticket_category_id')
                    ->numeric(),
                TextEntry::make('presale_period_id')
                    ->numeric(),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('unit_price')
                    ->money(),
                TextEntry::make('total_price')
                    ->money(),
                TextEntry::make('payment_status'),
                TextEntry::make('xendit_invoice_id')
                    ->placeholder('-'),
                TextEntry::make('xendit_invoice_url')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('xendit_payment_method')
                    ->placeholder('-'),
                TextEntry::make('payment_confirmed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('scan_status'),
                TextEntry::make('scanned_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('wa_sent')
                    ->boolean(),
                TextEntry::make('wa_sent_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('email_sent')
                    ->boolean(),
                TextEntry::make('email_sent_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('ordered_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
