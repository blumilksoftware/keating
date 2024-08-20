<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var Setting $settings */
        $settings = Setting::query()->first();

        $title = "{$settings->teacher_titles} {$settings->teacher_name}, {$settings->university_name}";

        View::share("pageTitle", $title);
    }
}
