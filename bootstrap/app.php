<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        
        // Exclude tracking API from CSRF verification
        $middleware->validateCsrfTokens(except: [
            '/api/ads/track-impression',
            '/api/ads/track-click',
        ]);
        
        // Trust all proxies (for ngrok and other reverse proxies)
        $middleware->trustProxies(at: '*', headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR | 
            \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST | 
            \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT | 
            \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
