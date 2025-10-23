<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'webhooks/*',
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if (str($request->route()->getName())->startsWith('admin.')) {
                return route('auth.login', ['next' => $request->path()]);
            }

            return route('auth.player.login', ['next' => $request->path()]);
        });

        $middleware->redirectUsersTo(function (Request $request) {
            if (str($request->route()->getName())->startsWith('admin.')) {
                return route('dashboard');
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
