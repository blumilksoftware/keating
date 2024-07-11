<?php

declare(strict_types=1);

return [
    "name" => env("APP_NAME", "Keating"),
    "env" => env("APP_ENV", "production"),
    "debug" => (bool)env("APP_DEBUG", false),
    "url" => env("APP_URL", "http://localhost"),
    "asset_url" => env("ASSET_URL"),
    "timezone" => env("APP_TIMEZONE", "UTC"),
    "locale" => "pl",
    "fallback_locale" => "en",
    "faker_locale" => "pl",
    "key" => env("APP_KEY"),
    "cipher" => "AES-256-CBC",
    "maintenance" => [
        "driver" => "file",
    ],
    "previous_keys" => [
        ...array_filter(
            explode(",", env("APP_PREVIOUS_KEYS", "")),
        ),
    ],
];
