<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendCertificateWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        $downloadUrl = route('certificate.download', ['ticketCode' => $this->order->ticket_code]);

        $message = "*SERTIFIKAT DIGITAL SIAP*\n\n"
            . "Halo *{$this->order->certificate_name}*,\n\n"
            . "Sertifikat JUKUNG BULIK 2026 Anda telah berhasil dibuat.\n\n"
            . "*Kode Sertifikat:* `{$this->order->certificate_code}`\n"
            . "*Tautan Unduh:* {$downloadUrl}\n\n"
            . "Terima kasih atas partisipasi Anda dalam pertunjukan Jukung Bulik.";

        $httpClient = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ]);

        if (app()->environment('local') && config('app.debug')) {
            $httpClient->withoutVerifying();
        }

        $response = $httpClient->post('https://api.fonnte.com/send', [
            'target'      => $this->order->whatsapp,
            'message'     => $message,
            'countryCode' => '62',
        ]);

        if ($response->successful() && $response->json('status') === true) {
            $this->order->update([
                'certificate_sent_wa' => true,
            ]);
        } else {
            Log::warning('Fonnte WA certificate failed', [
                'order_id' => $this->order->id,
                'response' => $response->body(),
            ]);
            throw new \Exception('Fonnte WA certificate failed: ' . ($response->json('reason') ?? $response->body()));
        }
    }
}
