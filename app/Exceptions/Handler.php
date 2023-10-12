<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected array $handleByInertia = [
        Response::HTTP_INTERNAL_SERVER_ERROR,
        Response::HTTP_SERVICE_UNAVAILABLE,
        Response::HTTP_TOO_MANY_REQUESTS,
        419, // CSRF
        Response::HTTP_NOT_FOUND,
        Response::HTTP_FORBIDDEN,
        Response::HTTP_UNAUTHORIZED,
    ];

    public function render($request, Throwable $e): Response
    {
        $response = parent::render($request, $e);

        if (!app()->environment("production")) {
            return $response;
        }

        if ($response->status() === Response::HTTP_METHOD_NOT_ALLOWED) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        if (in_array($response->status(), $this->handleByInertia, true)) {
            return Inertia::render("Error", [
                "status" => $response->status(),
            ])
                ->toResponse($request)
                ->setStatusCode($response->status());
        }

        return $response;
    }
}
