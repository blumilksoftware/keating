<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Inertia\Response;
use Keating\Models\Course;
use Keating\Models\Group;
use Keating\Models\Semester;
use Keating\Models\Setting;
use Keating\Models\Student;

class DashboardController
{
    public function __invoke(): Response
    {
        $activeSemester = Semester::getActive();

        return inertia("Dashboard/Home", [
            "name" => explode(" ", Setting::query()->first()?->teacher_name ?? "")[0],
            "counters" => [
                [
                    ["name" => "Liczba studentów w tym semestrze", "value" => $activeSemester?->students()->count() ?? 0],
                    ["name" => "Liczba kursów w tym semestrze", "value" => $activeSemester?->courses()->count() ?? 0],
                    ["name" => "Liczba grup w tym semestrze", "value" => $activeSemester?->groups()->count() ?? 0],
                ],
                [
                    ["name" => "Liczba studentów", "value" => Student::query()->count()],
                    ["name" => "Liczba kursów", "value" => Course::query()->count()],
                    ["name" => "Liczba grup", "value" => Group::query()->count()],
                ],
            ],
        ]);
    }
}
