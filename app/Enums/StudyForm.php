<?php

declare(strict_types=1);

namespace App\Enums;

enum StudyForm: string
{
    case Stationary = "stationary";
    case PartTime = "part-time";

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
            "stationary" => __("S"),
            "part-time" => __("N"),
        ];
    }
}
