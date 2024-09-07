<?php

declare(strict_types=1);

return [
    "sections" => [
        "faq_enabled" => env("FAQ_ENABLED", true),
        "contact_enabled" => env("CONTACT_ENABLED", true),
        "news_enabled" => env("ABOUT_ENABLED", true),
    ],
];
