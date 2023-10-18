<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseSemesterResource;
use App\Models\CourseSemester;
use App\Models\GradeColumn;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class GradeController extends Controller
{
    public function index(Request $request, CourseSemester $course, Group $group): Response
    {
        $students = $group->students()
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/CourseSemester/Grade/Index", [
            "course" => new CourseSemesterResource($course),
            "group" => $group,
            "students" => $students,
            "gradeColumns" => $group->gradeColumns()->with("grades")->get(),
        ]);
    }

    public function store(Request $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->gradeColumns()->create(["name" => $request->get("name"), "active" => true, "priority" => 1]);

        return redirect()->back()
            ->with("success", "Dodano kolumnę");
    }

    public function createOrUpdateGrade(Request $request, CourseSemester $course, Group $group, GradeColumn $gradeColumn)
    {
        $gradeColumn->grades()
            ->updateOrCreate([
                "student_id" => $request->get("student_id"),
            ], [
                "value" => $request->get("value"),
                "status" => $request->get("status"),
            ]);

        return redirect()->back()
            ->with("success", "Zaktualizowano ocenę");
    }
}
