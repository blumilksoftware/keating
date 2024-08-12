<?php

declare(strict_types=1);

use Illuminate\Support\Str;

return [
    "default" => env("DB_CONNECTION", "pgsql"),
    "connections" => [
        "pgsql" => [
            "driver" => "pgsql",
            "url" => env("DATABASE_URL"),
            "host" => env("DB_HOST", "keating-db-dev"),
            "port" => env("DB_PORT", "5432"),
            "database" => env("DB_DATABASE", "keating"),
            "username" => env("DB_USERNAME", "keating"),
            "password" => env("DB_PASSWORD", "password"),
            "charset" => "utf8",
            "prefix" => "",
            "prefix_indexes" => true,
            "search_path" => "public",
            "sslmode" => "prefer",
        ],
    ],
    "migrations" => "migrations",
    "redis" => [
        "client" => env("REDIS_CLIENT", "phpredis"),
        "options" => [
            "cluster" => env("REDIS_CLUSTER", "redis"),
            "prefix" => env("REDIS_PREFIX", Str::slug(env("APP_NAME", "laravel"), "_") . "_database_"),
        ],
        "default" => [
            "url" => env("REDIS_URL"),
            "host" => env("REDIS_HOST", "keating-redis-dev"),
            "username" => env("REDIS_USERNAME"),
            "password" => env("REDIS_PASSWORD"),
            "port" => env("REDIS_PORT", "6379"),
            "database" => env("REDIS_DB", "0"),
        ],
        "cache" => [
            "url" => env("REDIS_URL"),
            "host" => env("REDIS_HOST", "keating-redis-dev"),
            "username" => env("REDIS_USERNAME"),
            "password" => env("REDIS_PASSWORD"),
            "port" => env("REDIS_PORT", "6379"),
            "database" => env("REDIS_CACHE_DB", "1"),
        ],
    ],
];
