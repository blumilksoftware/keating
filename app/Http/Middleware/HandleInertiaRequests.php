<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = "app";

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            "flash" => $this->getFlashData($request),
        ]);
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
