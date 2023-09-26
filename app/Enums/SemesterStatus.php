<?php

declare(strict_types=1);

namespace App\Enums;

enum SemesterStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;

    public function getLabel(): string
    {
        return match ($this->value) {
            1 => "aktywny",
            0 => "nieaktywny",
        };
    }
}
