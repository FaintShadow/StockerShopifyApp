<?php

use App\Http\Middleware\AccessControlHeaders;
use App\Http\Middleware\CspHeader;
use App\Http\Middleware\EnsureShopifyInstalled;
use App\Http\Middleware\EnsureShopifySession;
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
        $middleware->append(AccessControlHeaders::class);

        $middleware->web([
            CspHeader::class
        ]);

        $middleware->alias([
            'shopify.auth' => EnsureShopifySession::class,
            'shopify.installed' => EnsureShopifyInstalled::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
