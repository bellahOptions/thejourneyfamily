<?php

use App\Models\ConsultationBooking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an admin can view consultation requests', function () {
    $admin = User::factory()->admin()->create();
    $booking = ConsultationBooking::factory()->create(['couple_name' => 'Ade and Bola']);

    $this->actingAs($admin)
        ->get(route('admin.consultations.index'))
        ->assertOk()
        ->assertSee('Ade and Bola');
});

test('an admin can update a consultation status', function () {
    $admin = User::factory()->admin()->create();
    $booking = ConsultationBooking::factory()->create(['status' => ConsultationBooking::STATUS_PENDING]);

    $response = $this->actingAs($admin)->patch(route('admin.consultations.status', $booking), [
        'status' => ConsultationBooking::STATUS_SCHEDULED,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('consultation_bookings', [
        'id' => $booking->id,
        'status' => ConsultationBooking::STATUS_SCHEDULED,
    ]);
});

test('a non-admin cannot access consultations', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.consultations.index'))
        ->assertForbidden();
});
