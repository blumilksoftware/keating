<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(CacheManager $cache): void
    {
        $title = $cache->get("pageTitle");

        if (!$title) {
            /** @var ?Setting $settings */
            try {
                $settings = Setting::query()->first();
            } catch (QueryException) {
                $settings = null;
            }

            $title = $settings
                ? "{$settings->teacher_titles} {$settings->teacher_name}, {$settings->university_name}"
                : config("app.name");

            $cache->put("pageTitle", $title);
        }

        View::share("pageTitle", $title);
    }
}
