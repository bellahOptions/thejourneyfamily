<?php

namespace App\Mail;

use App\Models\ConsultationBooking;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewConsultationBookingNotification extends Mailable
{
    public function __construct(public ConsultationBooking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('retreat.name')),
            subject: 'New consultation request: '.$this->booking->couple_name
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.consultations.organizer',
        );
    }
}
