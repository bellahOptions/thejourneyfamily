<?php

test('common security headers are present on every response', function () {
    $response = $this->get('/');

    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('X-Frame-Options', 'DENY');
    $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->assertHeader('Permissions-Policy');
});

test('a content security policy is only enforced in production', function () {
    $this->get('/')->assertHeaderMissing('Content-Security-Policy');

    $this->app['env'] = 'production';

    $this->get('/')
        ->assertHeader('Content-Security-Policy')
        ->assertHeader('Strict-Transport-Security');

    $this->app['env'] = 'testing';
});
