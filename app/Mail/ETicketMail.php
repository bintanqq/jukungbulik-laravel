<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ETicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        private string $pdfContent
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "E-Ticket JUKUNG BULIK — {$this->order->ticket_code}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.eticket',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                "eticket-{$this->order->ticket_code}.pdf"
            )->withMime('application/pdf'),
        ];
    }
}
