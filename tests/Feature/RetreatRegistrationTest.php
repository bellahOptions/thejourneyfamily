<?php

use App\Mail\OrganizerRegistrationNotification;
use App\Mail\ParticipantRegistrationConfirmation;
use App\Models\RetreatRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('the landing page shows the homepage', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('The Journey Couples Retreat S6')
        ->assertSee('Package 1')
        ->assertSee('NGN 50,000')
        ->assertSee('Register now');
});

test('the registration page shows the form', function () {
    $this->get(route('registrations.create'))
        ->assertOk()
        ->assertSee('Submit registration');
});

test('a participant can submit a registration and receive confirmation', function () {
    Mail::fake();

    $response = $this->post(route('registrations.store'), [
        'couple_name' => 'Ade and Bola',
        'email' => 'ade@example.com',
        'anniversary_day' => 22,
        'anniversary_month' => 8,
        'participant_whatsapp' => '+2348012345678',
        'spouse_whatsapp' => '+2348098765432',
        'transport_status' => 'Yes',
        'bringing_children' => 'No',
        'children_ages' => null,
        'expectations' => 'A refreshing time together.',
        'prayer_request' => 'Growth and unity.',
        'previous_feedback' => null,
        'payment_made' => 'Yes',
        'payment_proof_note' => null,
        'package_key' => 'standard-ac-room',
        'questions' => 'None for now.',
        'consent' => '1',
        'hp_field' => '',
    ]);

    $registration = RetreatRegistration::query()->firstOrFail();

    $response->assertRedirect(route('registrations.confirmation', $registration));

    $this->assertDatabaseHas('retreat_registrations', [
        'email' => 'ade@example.com',
        'package_key' => 'standard-ac-room',
        'package_price' => 70000,
    ]);

    Mail::assertSent(
        ParticipantRegistrationConfirmation::class,
        fn (ParticipantRegistrationConfirmation $mail) => $mail->hasTo('ade@example.com')
    );
    Mail::assertSent(OrganizerRegistrationNotification::class);
});

test('the honeypot field silently rejects bot submissions', function () {
    $response = $this->post(route('registrations.store'), [
        'couple_name' => 'Bot Submission',
        'email' => 'bot@example.com',
        'anniversary_day' => 1,
        'anniversary_month' => 1,
        'participant_whatsapp' => '+2348012345678',
        'spouse_whatsapp' => '+2348098765432',
        'transport_status' => 'Yes',
        'bringing_children' => 'No',
        'payment_made' => 'Yes',
        'package_key' => 'standard-ac-room',
        'consent' => '1',
        'hp_field' => 'I am a bot',
    ]);

    $response->assertSessionHasErrors('couple_name');
    $this->assertDatabaseCount('retreat_registrations', 0);
});

test('an invalid day for the selected anniversary month is rejected', function () {
    $response = $this->post(route('registrations.store'), [
        'couple_name' => 'Ade and Bola',
        'email' => 'ade@example.com',
        'anniversary_day' => 30,
        'anniversary_month' => 2,
        'participant_whatsapp' => '+2348012345678',
        'spouse_whatsapp' => '+2348098765432',
        'transport_status' => 'Yes',
        'bringing_children' => 'No',
        'payment_made' => 'Yes',
        'package_key' => 'standard-ac-room',
        'consent' => '1',
        'hp_field' => '',
    ]);

    $response->assertSessionHasErrors('anniversary_day');
    $this->assertDatabaseCount('retreat_registrations', 0);
});
