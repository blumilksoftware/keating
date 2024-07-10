<?php

declare(strict_types=1);

return [
    "default" => env("MAIL_MAILER", "smtp"),
    "mailers" => [
        "smtp" => [
            "transport" => "smtp",
            "url" => env("MAIL_URL"),
            "host" => env("MAIL_HOST", "mailpit"),
            "port" => env("MAIL_PORT", 1025),
            "encryption" => env("MAIL_ENCRYPTION", "tls"),
            "username" => env("MAIL_USERNAME"),
            "password" => env("MAIL_PASSWORD"),
            "timeout" => null,
            "local_domain" => env("MAIL_EHLO_DOMAIN"),
        ],
        "log" => [
            "transport" => "log",
            "channel" => env("MAIL_LOG_CHANNEL"),
        ],
        "array" => [
            "transport" => "array",
        ],
        "failover" => [
            "transport" => "failover",
            "mailers" => [
                "smtp",
                "log",
            ],
        ],
    ],
    "from" => [
        "address" => env("MAIL_FROM_ADDRESS", "keating@example.com"),
        "name" => env("MAIL_FROM_NAME", "Keating"),
    ],
    "markdown" => [
        "theme" => "default",
        "paths" => [
            resource_path("views/vendor/mail"),
        ],
    ],
];
