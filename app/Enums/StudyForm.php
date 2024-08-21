<?php

declare(strict_types=1);

namespace Keating\Enums;

enum StudyForm: string
{
    case Stationary = "stationary";
    case PartTime = "part-time";
    case StudyAndWork = "study-and-work";

    public static function labels(): array
    {
        return [
            "stationary" => __("stationary"),
            "part-time" => __("part-time"),
            "study-and-work" => __("study and work"),
        ];
    }

    public static function abbreviationLabels(): array
    {
        return [
            "stationary" => __("S"),
            "part-time" => __("N"),
            "study-and-work" => __("W"),
        ];
    }
}
