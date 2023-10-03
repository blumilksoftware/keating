<?php

declare(strict_types=1);

namespace App\Enums;

enum ClassType: string
{
    case LABORATORY = "laboratory";
    case LECTURE = "lecture";
    case SEMINAR = "seminar";
    case WORKSHOP = "workshop";
    case EXERCISES = "exercises";
    case PROJECT = "project";

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
            "exercises" => __("ĆW"),
            "project" => __("P"),
        ];
    }
}
