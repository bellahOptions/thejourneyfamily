<?php

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a visitor can submit an anonymous question', function () {
    $response = $this->post(route('questions.store'), [
        'body' => 'How do we handle conflict better?',
        'hp_field' => '',
    ]);

    $response->assertRedirect(route('questions.create'));
    $this->assertDatabaseHas('questions', [
        'body' => 'How do we handle conflict better?',
        'status' => Question::STATUS_PENDING,
    ]);
});

test('the live data endpoint returns featured questions', function () {
    Question::factory()->create(['body' => 'Pending question', 'status' => Question::STATUS_PENDING]);
    $featured = Question::factory()->create(['body' => 'Featured question', 'status' => Question::STATUS_FEATURED]);

    $response = $this->getJson(route('questions.live-data'));

    $response->assertOk()
        ->assertJsonCount(1, 'questions')
        ->assertJsonFragment(['body' => $featured->body]);
});

test('the live data endpoint falls back to pending questions when none are featured', function () {
    Question::factory()->create(['body' => 'Pending question', 'status' => Question::STATUS_PENDING]);

    $response = $this->getJson(route('questions.live-data'));

    $response->assertOk()->assertJsonCount(1, 'questions');
});

test('hidden questions never appear in the live data feed', function () {
    Question::factory()->create([
        'body' => 'Hidden featured question',
        'status' => Question::STATUS_FEATURED,
        'is_hidden' => true,
    ]);

    $response = $this->getJson(route('questions.live-data'));

    $response->assertOk()->assertJsonCount(0, 'questions');
});
