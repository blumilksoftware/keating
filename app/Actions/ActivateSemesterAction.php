<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\SemesterStatus;
use App\Models\Semester;

class ActivateSemesterAction
{
    public function execute(Semester $semester): void
    {
        Semester::getActive()?->update(["status" => SemesterStatus::INACTIVE]);
        $semester->update(["status" => SemesterStatus::ACTIVE]);
    }
}
