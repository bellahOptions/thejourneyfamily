<?php

use App\Mail\NewConsultationBookingNotification;
use App\Models\ConsultationBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('a couple can request a consultation', function () {
    Mail::fake();

    $response = $this->post(route('consultations.store'), [
        'couple_name' => 'Ade and Bola',
        'whatsapp' => '+2348012345678',
        'email' => 'ade@example.com',
        'notes' => 'We would like help with communication.',
        'hp_field' => '',
    ]);

    $response->assertRedirect(route('consultations.create'));

    $this->assertDatabaseHas('consultation_bookings', [
        'couple_name' => 'Ade and Bola',
        'whatsapp' => '+2348012345678',
        'email' => 'ade@example.com',
        'status' => ConsultationBooking::STATUS_PENDING,
    ]);

    Mail::assertSent(
        NewConsultationBookingNotification::class,
        fn (NewConsultationBookingNotification $mail) => $mail->booking->couple_name === 'Ade and Bola'
    );
});

test('a consultation can be requested without an email', function () {
    $response = $this->post(route('consultations.store'), [
        'couple_name' => 'Ade and Bola',
        'whatsapp' => '+2348012345678',
        'hp_field' => '',
    ]);

    $response->assertRedirect(route('consultations.create'));
    $this->assertDatabaseHas('consultation_bookings', [
        'couple_name' => 'Ade and Bola',
        'email' => null,
    ]);
});

test('the honeypot silently rejects bot consultation requests', function () {
    $response = $this->post(route('consultations.store'), [
        'couple_name' => 'Bot',
        'whatsapp' => '+2348012345678',
        'hp_field' => 'filled',
    ]);

    $response->assertSessionHasErrors('couple_name');
    $this->assertDatabaseCount('consultation_bookings', 0);
});
