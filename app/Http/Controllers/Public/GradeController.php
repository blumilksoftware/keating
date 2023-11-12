<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CourseSemester;
use App\Models\Grade;
use App\Models\GradeColumn;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Student;
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

        if ($semester) {
            $courses = $semester->courses()->with("course")->get();
        }

        if ($course) {
            $groups = $course->groups;
        }

        if ($group) {
            $gradeColumns = $group
                ->gradeColumns()
                ->where("active", true)
                ->orderBy("priority")
                ->get();
            $studentByIndex = $group->students()
                ->where("index_number", $index)
                ->first();
            $students = $group->students()
                ->whereNot("index_number", $index)
                ->inRandomOrder()
                ->take(8)
                ->get()
                ->push($studentByIndex)
                ->sortBy("index_number")
                ->map(fn(Student $student): array => [
                    "student" => $student->id === $studentByIndex->id ? $student->index_number : "",
                    "grades" => $gradeColumns
                        ->map(function (GradeColumn $column) use ($student): array {
                            /** @var Grade $grade */
                            $grade = Grade::query()
                                ->where("grade_column_id", $column->id)
                                ->where("student_id", $student->id)
                                ->first();

                            return $grade
                                ? [
                                    "present" => $grade->status,
                                    "value" => $grade->value,
                                ]
                                : [
                                    "present" => false,
                                    "value" => null,
                                ];
                        }),
                ]);
        }

        return inertia("Public/Grade", [
            "semesters" => Semester::all(),
            "semester" => $semester,
            "courses" => $courses,
            "course" => $course,
            "groups" => $groups,
            "group" => $group,
            "index" => $index,
            "gradeColumns" => $gradeColumns,
            "students" => $students,
            "indexExists" => $studentByIndex->exists(),
        ]);
    }
}
