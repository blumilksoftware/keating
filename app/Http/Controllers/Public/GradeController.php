<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\DTOs\StudentData;
use App\Http\Controllers\Controller;
use App\Models\CourseSemester;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Inertia\Response;

class GradeController extends Controller
{
    public function __invoke(Request $request, ?Semester $semester = null, ?CourseSemester $course = null, ?Group $group = null, ?string $index = null): Response
    {
        $courses = [];
        $groups = [];
        $gradeColumns = [];
        $students = [];
        $studentByIndex = null;

        if ($semester) {
            $courses = $semester
                ->courses()
                ->with("course", fn(BelongsTo $query): BelongsTo => $query->select(["name", "id"]))
                ->get();
        }

        if ($course) {
            $groups = $course
                ->groups()
                ->get(["name", "id"]);
        }

        if ($group && $index) {
            $studentByIndex = $group->students()
                ->where("index_number", $index)
                ->first();

            if ($studentByIndex?->exists()) {
                $gradeColumns = $group
                    ->gradeColumns()
                    ->where("active", true)
                    ->orderBy("priority")
                    ->get();
                $students = $group->students()
                    ->whereNot("index_number", $index)
                    ->inRandomOrder()
                    ->take(8)
                    ->get()
                    ->push($studentByIndex)
                    ->sortBy("index_number")
                    ->map(fn(Student $student): StudentData => StudentData::fromModels($student, $studentByIndex, $gradeColumns));
            }
        }

        return inertia("Public/Grade", [
            "semesters" => Semester::query()->get(["name", "id"]),
            "semester" => $semester,
            "courses" => $courses,
            "course" => $course,
            "groups" => $groups,
            "group" => $group,
            "index" => $index,
            "gradeColumns" => $gradeColumns,
            "students" => $students,
            "indexExists" => $studentByIndex?->exists(),
        ]);
    }
}
