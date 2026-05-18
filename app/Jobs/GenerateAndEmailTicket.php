<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\ETicketMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateAndEmailTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(200)
                ->errorCorrection('H')
                ->generate($this->order->ticket_code)
        );

        $pdf = Pdf::loadView('pdf.eticket', [
            'order'  => $this->order->load('ticketCategory'),
            'qrCode' => $qrCode,
        ])->setPaper([0, 0, 595, 420], 'landscape');

        Mail::to($this->order->email)
            ->send(new ETicketMail($this->order, $pdf->output()));

        $this->order->update([
            'email_sent'    => true,
            'email_sent_at' => now(),
        ]);
    }
}
