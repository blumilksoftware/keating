<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(CacheManager $cache, Factory $view): void
    {
        $title = $cache->get("pageTitle", function () use ($cache): string {
            try {
                $settings = Setting::query()->first();
            } catch (QueryException) {
                $settings = null;
            }

            $title = $settings
                ? "{$settings->teacher_titles} {$settings->teacher_name}, {$settings->university_name}"
                : config("app.name");

            $cache->put("pageTitle", $title);

            return $title;
        });

        $view->share("pageTitle", $title);
    }
}
