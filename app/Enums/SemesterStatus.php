<?php

declare(strict_types=1);

namespace App\Enums;

enum SemesterStatus: string
{
    case ACTIVE = "active";
    case INACTIVE = "inactive";

    public function getLabel(): string
    {
        return match ($this->value) {
            "active" => "aktywny",
            "inactive" => "nieaktywny",
        };
    }
}
