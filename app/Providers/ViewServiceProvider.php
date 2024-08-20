<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function boot(): void
    {
        $title = app(CacheManager::class)->get("pageTitle");

        if (!$title) {
            /** @var Setting $settings */
            $settings = Setting::query()->first();

            $title = $settings
                ? "{$settings->teacher_titles} {$settings->teacher_name}, {$settings->university_name}"
                : config("app.name");

            app(CacheManager::class)->put("pageTitle", $title);
        }

        View::share("pageTitle", $title);
    }
}
