<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('a strong password creates an admin that must change it on first login', function () {
    $this->artisan('admin:create', [
        '--name' => 'Bellah',
        '--email' => 'bellah@example.com',
        '--password' => 'StrongPass1',
    ])->assertSuccessful();

    $admin = User::query()->where('email', 'bellah@example.com')->firstOrFail();

    expect($admin->is_admin)->toBeTrue();
    expect($admin->must_change_password)->toBeTrue();
});

test('a weak password is rejected without the allow-weak-password flag', function () {
    $this->artisan('admin:create', [
        '--name' => 'Bellah',
        '--email' => 'bellah@example.com',
        '--password' => '12345',
    ])->assertFailed();

    $this->assertDatabaseCount('users', 0);
});

test('a weak password is accepted with the allow-weak-password flag, still forcing a change', function () {
    $this->artisan('admin:create', [
        '--name' => 'Bellah',
        '--email' => 'bellah@example.com',
        '--password' => '12345',
        '--allow-weak-password' => true,
    ])->assertSuccessful();

    $admin = User::query()->where('email', 'bellah@example.com')->firstOrFail();

    expect($admin->must_change_password)->toBeTrue();
    expect(Hash::check('12345', $admin->password))->toBeTrue();
});
