<?php

declare(strict_types=1);

namespace App\Providers;

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

        View::share("pageTitle", $title);
    }
}
