<?php

namespace App\Filament\Pages;

use App\Models\EventSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class StreamingSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'Pengaturan Streaming';
    protected static ?string $title = 'Pengaturan Streaming Live';
    protected string $view = 'filament.pages.streaming-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'youtube_live_url' => EventSetting::where('key', 'youtube_live_url')->value('value') ?? '',
            'streaming_enabled' => EventSetting::where('key', 'streaming_enabled')->value('value') === 'true',
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Section::make('Konfigurasi Live Streaming')
                    ->description('Atur tautan YouTube siaran langsung dan akses penonton ke halaman streaming.')
                    ->schema([
                        Forms\Components\TextInput::make('youtube_live_url')
                            ->label('Tautan YouTube Live')
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Kosongkan jika siaran belum dimulai.')
                            ->nullable(),

                        Forms\Components\Toggle::make('streaming_enabled')
                            ->label('Aktifkan Halaman Streaming')
                            ->helperText('Jika diaktifkan, pemilik tiket streaming dapat masuk dan menonton live.')
                            ->default(true),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        DB::transaction(function () use ($data) {
            EventSetting::updateOrCreate(
                ['key' => 'youtube_live_url'],
                ['value' => $data['youtube_live_url'] ?? '']
            );
            EventSetting::updateOrCreate(
                ['key' => 'streaming_enabled'],
                ['value' => $data['streaming_enabled'] ? 'true' : 'false']
            );
        });

        $this->dispatch('notify', type: 'success', message: 'Pengaturan streaming berhasil disimpan.');
    }
}
