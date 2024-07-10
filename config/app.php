<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\BuilderServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

$providers = ServiceProvider::defaultProviders()->merge([
    AppServiceProvider::class,
    EventServiceProvider::class,
    RouteServiceProvider::class,
    BuilderServiceProvider::class,
])->toArray();

return [
    "name" => env("APP_NAME", "Laravel"),
    "env" => env("APP_ENV", "production"),
    "debug" => (bool)env("APP_DEBUG", false),
    "url" => env("APP_URL", "http://localhost"),
    "asset_url" => env("ASSET_URL"),
    "timezone" => "UTC",
    "locale" => "pl",
    "fallback_locale" => "en",
    "faker_locale" => "en_US",
    "key" => env("APP_KEY"),
    "cipher" => "AES-256-CBC",
    "maintenance" => [
        "driver" => "file",
    ],
    "providers" => $providers,
    "aliases" => Facade::defaultAliases()->merge([])->toArray(),
];
