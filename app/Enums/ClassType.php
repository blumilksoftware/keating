<?php

declare(strict_types=1);

namespace App\Enums;

enum ClassType: string
{
    case LABORATORY = "laboratory";
    case LECTURE = "lecture";

    public static function labels(): array
    {
        return [
            "laboratory" => __("laboratory"),
            "lecture" => __("lecture"),
        ];
    }
}
