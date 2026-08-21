<?php

namespace App\Filament\Pages;

use App\Models\EventSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class CertificateSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Pengaturan Sertifikat';
    protected static ?string $title = 'Pengaturan Sertifikat Digital';
    protected string $view = 'filament.pages.certificate-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'certificate_enabled' => EventSetting::where('key', 'certificate_enabled')->value('value') === 'true',
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Section::make('Konfigurasi Sertifikat Digital')
                    ->description('Atur status klaim sertifikat kehadiran dan akses unduh peserta.')
                    ->schema([
                        Forms\Components\Toggle::make('certificate_enabled')
                            ->label('Aktifkan Klaim Sertifikat')
                            ->helperText('Jika diaktifkan, peserta dapat mengklaim dan mengunduh sertifikat digital melalui halaman /sertifikat.')
                            ->default(true),

                        Forms\Components\Placeholder::make('template_info')
                            ->label('Panduan Berkas Template')
                            ->content('Template gambar sertifikat: storage/app/certificate-template.png | Jenis font kustom: public/fonts/CertificateFont.ttf'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        DB::transaction(function () use ($data) {
            EventSetting::updateOrCreate(
                ['key' => 'certificate_enabled'],
                ['value' => $data['certificate_enabled'] ? 'true' : 'false']
            );
        });

        $this->dispatch('notify', type: 'success', message: 'Pengaturan sertifikat berhasil disimpan.');
    }
}
