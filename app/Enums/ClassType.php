<?php

declare(strict_types=1);

namespace Keating\Enums;

enum ClassType: string
{
    case Laboratory = "laboratory";
    case Lecture = "lecture";
    case Seminar = "seminar";
    case Workshop = "workshop";
    case Exercises = "exercises";
    case Project = "project";

    public static function labels(): array
    {
        return [
            "laboratory" => __("laboratory"),
            "lecture" => __("lecture"),
            "seminar" => __("seminar"),
            "workshop" => __("workshop"),
            "exercises" => __("exercises"),
            "project" => __("project"),
        ];
    }

    public static function abbreviationLabels(): array
    {
        return [
            "laboratory" => __("L"),
            "lecture" => __("W"),
            "seminar" => __("S"),
            "workshop" => __("WT"),
            "exercises" => __("C"),
            "project" => __("P"),
        ];
    }
}
