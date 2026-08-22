<?php

use App\Models\RetreatRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

$makeRegistration = function (array $overrides = []): RetreatRegistration {
    return RetreatRegistration::create(array_merge([
        'confirmation_token' => (string) Str::uuid(),
        'couple_name' => 'Ade and Bola',
        'email' => 'ade@example.com',
        'anniversary_day' => 22,
        'anniversary_month' => 8,
        'participant_whatsapp' => '+2348012345678',
        'spouse_whatsapp' => '+2348098765432',
        'transport_status' => 'Yes',
        'bringing_children' => 'No',
        'payment_made' => 'Yes',
        'package_key' => 'standard-ac-room',
        'package_label' => 'Package 2 - Standard AC Room',
        'package_price' => 70000,
        'consent_at' => now(),
    ], $overrides));
};

test('the dashboard shows registration counts', function () use ($makeRegistration) {
    $admin = User::factory()->admin()->create();
    $makeRegistration();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('1');
});

test('the registrations index lists registrations', function () use ($makeRegistration) {
    $admin = User::factory()->admin()->create();
    $registration = $makeRegistration();

    $this->actingAs($admin)
        ->get(route('admin.registrations.index'))
        ->assertOk()
        ->assertSee($registration->couple_name);
});

test('the registration detail page shows full submission', function () use ($makeRegistration) {
    $admin = User::factory()->admin()->create();
    $registration = $makeRegistration(['prayer_request' => 'Growth and unity.']);

    $this->actingAs($admin)
        ->get(route('admin.registrations.show', $registration))
        ->assertOk()
        ->assertSee($registration->couple_name)
        ->assertSee('Growth and unity.');
});
