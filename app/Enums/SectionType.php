<?php

declare(strict_types=1);

namespace App\Enums;

enum SectionType: string
{
    case About = "about";
    case Counter = "counter";

    public static function labels(): array
    {
        return [
            "about" => __("About"),
            "counter" => __("Counters"),
        ];
    }
}
