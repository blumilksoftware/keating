<?php

declare(strict_types=1);

namespace App\Enums;

enum SemesterName: string
{
    case Summer = "summer";
    case Winter = "winter";

    public static function labels(): array
    {
        return [
            "summer" => __("Summer"),
            "winter" => __("Winter"),
        ];
    }
}
