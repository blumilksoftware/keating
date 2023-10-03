<?php

declare(strict_types=1);

namespace App\Enums;

enum StudyForm: string
{
    case STATIONARY = "stationary";
    case PART_TIME = "part-time";

    public static function labels(): array
    {
        return [
            "stationary" => __("stationary"),
            "part-time" => __("part-time"),
        ];
    }

    public static function abbreviationLabels(): array
    {
        return [
            "part-time" => __("N"),
        ];
    }
}
