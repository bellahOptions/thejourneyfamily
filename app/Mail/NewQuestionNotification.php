<?php

namespace App\Mail;

use App\Models\Question;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewQuestionNotification extends Mailable
{
    public function __construct(public Question $question) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('retreat.name')),
            subject: 'New anonymous question submitted'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.questions.organizer',
        );
    }
}
