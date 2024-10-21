<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Keating\Http\Middleware\HandleInertiaRequests;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            HandleInertiaRequests::class,
        ]);
        $middleware->trustProxies("*");
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        Integration::handles($exceptions);

        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if (!app()->environment("production")) {
                return $response;
            }

            $handledStatuses = [
                Response::HTTP_INTERNAL_SERVER_ERROR,
                Response::HTTP_SERVICE_UNAVAILABLE,
                Response::HTTP_TOO_MANY_REQUESTS,
                419,
                Response::HTTP_NOT_FOUND,
                Response::HTTP_FORBIDDEN,
                Response::HTTP_UNAUTHORIZED,
            ];

            if ($response->getStatusCode() === Response::HTTP_METHOD_NOT_ALLOWED) {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
            }

            if (in_array($response->getStatusCode(), $handledStatuses, strict: true)) {
                return Inertia::render("Error", [
                    "status" => $response->getStatusCode(),
                ])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            return $response;
        });
    })->create();
