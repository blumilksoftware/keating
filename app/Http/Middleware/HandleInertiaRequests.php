<?php

declare(strict_types=1);

namespace Keating\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            "auth" => $this->getAuthData($request),
            "flash" => $this->getFlashData($request),
        ]);
    }

    protected function getAuthData(Request $request): array
    {
        return [
            "user" => $request->user() ? $request->user()->only("id", "name", "email") : null,
        ];
    }

    protected function getFlashData(Request $request): Closure
    {
        return fn(): array => [
            "success" => $request->session()->get("success"),
            "error" => $request->session()->get("error"),
            "info" => $request->session()->get("info"),
        ];
    }
}
