<?php

use App\Console\Handler as ScheduleHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            EnsureFrontendRequestsAreStateful::class,
            // ThrottleRequests::class . ':api',
            // SubstituteBindings::class
        ]);
    })
    ->withSchedule(new ScheduleHandler())
    ->withExceptions(function (Exceptions $exceptions) {
    })
    ->create();
