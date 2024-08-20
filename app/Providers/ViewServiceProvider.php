<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $title = Cache::get("pageTitle");

        if (!$title) {
            /** @var Setting $settings */
            $settings = Setting::query()->first();

            $title = $settings
                ? "{$settings->teacher_titles} {$settings->teacher_name}, {$settings->university_name}"
                : config("app.name");

            Cache::put("pageTitle", $title);
        }

        View::share("pageTitle", $title);
    }
}
