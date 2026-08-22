<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the admin login page is accessible to guests', function () {
    $this->get(route('admin.login'))->assertOk();
});

test('an admin can log in and reach the dashboard', function () {
    $admin = User::factory()->admin()->create(['email' => 'admin@example.com', 'password' => 'password']);

    $response = $this->post(route('admin.login.attempt'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('invalid credentials are rejected', function () {
    User::factory()->admin()->create(['email' => 'admin@example.com', 'password' => 'password']);

    $response = $this->post(route('admin.login.attempt'), [
        'email' => 'admin@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('a non-admin user cannot access the dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('a guest is redirected away from the dashboard', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

test('an admin can log out', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});

test('an admin who must change their password is redirected there instead of the dashboard', function () {
    $admin = User::factory()->admin()->create(['must_change_password' => true]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.password.edit'));
});

test('an admin who must change their password can still reach the password page directly', function () {
    $admin = User::factory()->admin()->create(['must_change_password' => true]);

    $this->actingAs($admin)
        ->get(route('admin.password.edit'))
        ->assertOk();
});

test('changing the password clears the must-change flag and unlocks the dashboard', function () {
    $admin = User::factory()->admin()->create([
        'password' => 'temp-password',
        'must_change_password' => true,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.password.update'), [
        'current_password' => 'temp-password',
        'password' => 'BrandNew123',
        'password_confirmation' => 'BrandNew123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));

    $admin->refresh();
    expect($admin->must_change_password)->toBeFalse();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

test('the current password is verified before allowing a password change', function () {
    $admin = User::factory()->admin()->create(['password' => 'temp-password']);

    $response = $this->actingAs($admin)->put(route('admin.password.update'), [
        'current_password' => 'wrong-password',
        'password' => 'BrandNew123',
        'password_confirmation' => 'BrandNew123',
    ]);

    $response->assertSessionHasErrors('current_password');
});
