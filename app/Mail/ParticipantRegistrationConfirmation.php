<?php

namespace App\Mail;

use App\Models\RetreatRegistration;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ParticipantRegistrationConfirmation extends Mailable
{
    public function __construct(public RetreatRegistration $registration)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('retreat.name')),
            subject: 'Your The Journey Couples Retreat S6 registration'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.registrations.participant',
            with: [
                'eventDate' => $this->registration->eventDate(),
                'payment' => config('retreat.payment'),
            ],
        );
    }
}
