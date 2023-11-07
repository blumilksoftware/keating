<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Student;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return inertia("Dashboard/Home", [
            "name" => explode(" ", Setting::query()->first()?->teacher_name ?? "")[0],
            "counters" => [
                [
                    ["name" => "Liczba studentów w tym semestrze", "value" => Semester::getActive()?->students()->count() ?? 0],
                    ["name" => "Liczba kursów w tym semestrze", "value" => Semester::getActive()?->courses()->count() ?? 0],
                    ["name" => "Liczba grup w tym semestrze", "value" => Semester::getActive()?->groups()->count() ?? 0],
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
