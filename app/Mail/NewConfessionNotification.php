<?php

namespace App\Mail;

use App\Models\Confession;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewConfessionNotification extends Mailable
{
    public function __construct(public Confession $confession) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('retreat.name')),
            subject: 'New anonymous confession submitted'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.confessions.organizer',
        );
    }
}
