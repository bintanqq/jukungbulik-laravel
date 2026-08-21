<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\CertificateMail;
use App\Services\CertificateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCertificateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        $filePath = storage_path('app/certificates/' . $this->order->ticket_code . '.png');

        // Re-generate if file doesn't exist
        if (!file_exists($filePath)) {
            $service = new CertificateService();
            $service->generate($this->order, $this->order->certificate_name);
        }

        Mail::to($this->order->email)
            ->send(new CertificateMail($this->order, $filePath));

        $this->order->update([
            'certificate_sent_email' => true,
        ]);
    }
}
