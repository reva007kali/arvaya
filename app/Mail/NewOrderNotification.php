<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue; // Agar dikirim di background (cepat)

class NewOrderNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Invitation $invitation;

    // Terima data undangan saat class dipanggil
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            // Subject Email
            subject: 'Order Masuk: ' . $this->invitation->title . ' (' . $this->invitation->package_type . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_order', // Kita akan buat view ini di langkah selanjutnya
        );
    }

    public function attachments(): array
    {
        // Opsional: Lampirkan bukti transfer langsung di email
        return [
             Attachment::fromPath(storage_path('app/public/' . str_replace('storage/', '', $this->invitation->payment_proof))),
        ];
        // return [];
    }
}

