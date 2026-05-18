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

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        $code  = $this->order->ticket_code;
        $total = 'Rp' . number_format($this->order->total_price, 0, ',', '.');

        $message = "✅ *Pembayaran Dikonfirmasi!*\n\n"
            . "Halo *{$this->order->nama}*!\n\n"
            . "Tiket JUKUNG BULIK kamu sudah LUNAS 🎭\n\n"
            . "📋 *Kode Tiket:* `{$code}`\n"
            . "💰 *Total:* {$total}\n\n"
            . "📧 *E-ticket PDF* dengan QR code sudah dikirim ke:\n"
            . "*{$this->order->email}*\n\n"
            . "Cek folder inbox atau spam ya!\n\n"
            . "📅 01 Oktober 2026 • 19.00 WITA\n"
            . "📍 Gedung Balairung Banjarmasin\n\n"
            . "_Sampai jumpa di pertunjukan!_ 🎉";

        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target'      => $this->order->whatsapp,
            'message'     => $message,
            'countryCode' => '62',
        ]);

        if ($response->successful()) {
            $this->order->update([
                'wa_sent'    => true,
                'wa_sent_at' => now(),
            ]);
        } else {
            Log::warning('Fonnte WA failed', [
                'order_id' => $this->order->id,
                'response' => $response->body(),
            ]);
        }
    }
}
