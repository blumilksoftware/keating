<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseSemesterResource;
use App\Models\CourseSemester;
use App\Models\GradeColumn;
use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class GradeController extends Controller
{
    public function index(Request $request, CourseSemester $course, Group $group): Response
    {
        $searchText = $request->query("search");
        $students = $group->students()->when(
            $searchText !== null,
            fn(Builder $query): Builder => $query
                ->where("first_name", "ILIKE", "%$searchText%")
                ->orWhere("surname", "ILIKE", "%$searchText%")
                ->orWhere("index_number", "LIKE", "%$searchText%"),
        )
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/CourseSemester/Grade/Index", [
            "course" => new CourseSemesterResource($course),
            "group" => $group,
            "students" => $students,
            "search" => $searchText,
            "gradeColumns" => $group->gradeColumns()->with("grades")->orderBy("priority")->get(),
        ]);
    }

    public function store(Request $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->gradeColumns()->create(["name" => $request->get("name"), "active" => $request->get("active")]);

        return redirect()->back()
            ->with("success", "Dodano kolumnę");
    }

    public function update(Request $request, CourseSemester $course, Group $group, GradeColumn $gradeColumn): RedirectResponse
    {
        $gradeColumn->update(["name" => $request->get("name"), "active" => $request->get("active")]);

        return redirect()->back()
            ->with("success", "Zaktualizowano kolumnę");
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

    public function destroy(CourseSemester $course, Group $group, GradeColumn $gradeColumn): RedirectResponse
    {
        $gradeColumn->delete();

        return redirect()->back()
            ->with("success", "Usunięto kolumnę");
    }

    public function reorder(CourseSemester $course, Group $group, GradeColumn $gradeColumn, int $down): RedirectResponse
    {
        $tempColumnOrder = $gradeColumn->priority;
        $columnToUpdate = $group->gradeColumns()->where("priority", $down ? "<" : ">", $gradeColumn->priority)->orderBy("priority", $down ? "desc" : "asc")->first();

        if ($columnToUpdate) {
            $gradeColumn->priority = $columnToUpdate->priority;
            $columnToUpdate->priority = $tempColumnOrder;
            $gradeColumn->save();
            $columnToUpdate->save();
        }

        return redirect()
            ->back()
            ->with(["success" => "Kolejność zaktualizowana"]);
    }
}