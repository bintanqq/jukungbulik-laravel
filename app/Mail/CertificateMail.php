<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        private string $certificatePath
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Sertifikat JUKUNG BULIK — {$this->order->certificate_name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->certificatePath)
                ->as("Sertifikat-{$this->order->certificate_name}.png")
                ->withMime('image/png'),
        ];
    }
}
