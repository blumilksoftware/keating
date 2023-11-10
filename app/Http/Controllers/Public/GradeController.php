<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CourseSemester;
use App\Models\Group;
use App\Models\Semester;
use Illuminate\Http\Request;
use Inertia\Response;

class GradeController extends Controller
{
    public function __invoke(Request $request, ?Semester $semester = null, ?CourseSemester $course = null, ?Group $group = null): Response
    {
        $courses = [];
        $groups = [];

        if ($semester) {
            $courses = $semester->courses()->with("course")->get();
        }

        if ($course) {
            $groups = $course->groups;
        }

        return inertia("Public/Grade", [
            "semesters" => Semester::all(),
            "semester" => $semester,
            "courses" => $courses,
            "course" => $course,
            "groups" => $groups,
            "group" => $group,
        ]);
    }
}
