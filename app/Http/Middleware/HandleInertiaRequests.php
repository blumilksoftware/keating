<?php

declare(strict_types=1);

namespace Keating\Http\Middleware;

use Closure;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Keating\Models\Setting;

class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            "auth" => $this->getAuthData($request),
            "flash" => $this->getFlashData($request),
            "settings" => $this->getSettingsData($request),
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

    protected function getSettingsData(Request $request): Closure
    {
        /** @var CacheManager $cache */
        $cache = app("cache");

        return fn(): array => [
            "scheduleLink" => $cache->get("scheduleLink", function () use ($cache): ?string {
                $link = Setting::query()->first()?->schedule_link;
                $cache->put("scheduleLink", $link);

                return $link;
            }),
        ];
    }
}
