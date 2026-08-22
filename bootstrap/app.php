<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\RequirePasswordChange;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
            'password.change' => RequirePasswordChange::class,
        ]);

        $middleware->web(append: [
            SecurityHeaders::class,
        ]);

        // The app is expected to sit behind a load balancer / CDN in
        // production (Laravel Cloud); trust the standard forwarded
        // headers from any upstream proxy so $request->ip() and
        // request->secure() reflect the real client, not the proxy.
        $middleware->trustProxies(at: '*');

        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
