<?php

namespace App\Mail;

use App\Models\EcommerceRefund;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EcommerceRefundSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EcommerceRefund $refund
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potwierdzenie zgłoszenia zwrotu #' . $this->refund->id
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.refunds.submitted'
        );
    }
}
