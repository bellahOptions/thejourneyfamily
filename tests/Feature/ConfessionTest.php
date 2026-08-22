<?php

use App\Mail\NewConfessionNotification;
use App\Models\Confession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('a visitor can submit an anonymous confession', function () {
    Mail::fake();

    $response = $this->post(route('confessions.store'), [
        'body' => 'I struggle to forgive quickly.',
        'hp_field' => '',
    ]);

    $response->assertRedirect(route('confessions.index'));
    $this->assertDatabaseHas('confessions', [
        'body' => 'I struggle to forgive quickly.',
    ]);

    Mail::assertSent(NewConfessionNotification::class, fn (NewConfessionNotification $mail) => $mail->confession->body === 'I struggle to forgive quickly.'
    );
});

test('the confessions page lists visible confessions', function () {
    Confession::factory()->create(['body' => 'A visible confession.']);
    Confession::factory()->create(['body' => 'A hidden confession.', 'is_hidden' => true]);

    $this->get(route('confessions.index'))
        ->assertOk()
        ->assertSee('A visible confession.')
        ->assertDontSee('A hidden confession.');
});

test('the honeypot silently rejects bot confessions', function () {
    $response = $this->post(route('confessions.store'), [
        'body' => 'Bot content',
        'hp_field' => 'filled',
    ]);

    $response->assertSessionHasErrors('body');
    $this->assertDatabaseCount('confessions', 0);
});
