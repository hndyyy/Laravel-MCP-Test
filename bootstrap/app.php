<?php

use App\Http\Middleware\ContentSecurityPolicyMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route; // Tambahkan ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // --- TAMBAHAN: Load routes/ai.php secara manual ---
        then: function () {
            Route::middleware('api') // Menggunakan middleware API (stateless)
                ->prefix('ai')       // URL akan diawali dengan /ai
                ->group(base_path('routes/ai.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->web(SetLocale::class);
        $middleware->web(append: [
            SetLocale::class,
            ContentSecurityPolicyMiddleware::class, // CSP middleware applied globally
        ]);

        // Register Spatie Permission middleware aliases
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // --- TAMBAHAN: Matikan CSRF untuk route AI ---
        $middleware->validateCsrfTokens(except: [
            'ai/*',           // Izinkan semua akses ke http://host/ai/...
            'tools/*',        // Jaga-jaga jika kamu ubah prefix
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();