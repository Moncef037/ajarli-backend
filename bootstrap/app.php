<?php

use App\Http\Middleware\EnsureAuthenticatedUserIsAdmin;
use App\Http\Middleware\EnsureAuthenticatedUserIsProvider;
use App\Http\Middleware\EnsureAuthenticatedUserIsRenter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'auth.provider' => EnsureAuthenticatedUserIsProvider::class,
            'auth.renter' => EnsureAuthenticatedUserIsRenter::class,
            'auth.admin' => EnsureAuthenticatedUserIsAdmin::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
