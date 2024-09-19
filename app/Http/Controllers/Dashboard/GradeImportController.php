<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Inertia\Response;
use Keating\DTOs\CourseSemesterData;
use Keating\Models\CourseSemester;
use Keating\Models\Grade;
use Keating\Models\GradeColumn;
use Keating\Models\Group;

class GradeImportController
{
    public function index(CourseSemester $course, Group $group, GradeColumn $column): Response
    {
        return inertia("Dashboard/CourseSemester/Grade/Import", [
            "course" => CourseSemesterData::fromModel($course),
            "group" => $group,
            "column" => $column,
            "csrfToken" => csrf_token(),
        ]);
    }

    public function prepare(Request $request, CourseSemester $course, Group $group, GradeColumn $column, ResponseFactory $response): JsonResponse
    {
        $students = $request;

        return $response->json([
            "students" => $column->refresh()->grades->map(fn(Grade $grade): array => [
                "id" => $grade->id,
                "column" => [
                    "id" => $column->id,
                ],
                "student" => [
                    "id" => $grade->student->id,
                    "name" => $grade->student->fullName,
                    "indexNumber" => $grade->student->index_number,
                ],
                "status" => $grade->status,
                "value" => $grade->value,
                "imported" => rand(0, 1) > .5,
            ]),
        ]);
    }
}
