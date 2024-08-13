<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGrade;
use App\Http\Requests\UpdateGradeColumn;
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
                ->whereLikeUnaccentInsensitive("first_name", $searchText)
                ->orWhereLikeUnaccentInsensitive("surname", $searchText)
                ->orWhere("index_number", "LIKE", "%$searchText%"),
        )
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/CourseSemester/Grade/Index", [
            "course" => new CourseSemesterResource($course),
            "group" => $group,
            "total" => $group->students->count(),
            "students" => $students,
            "search" => $searchText,
            "gradeColumns" => $group->gradeColumns()->with("grades")->orderBy("priority")->get(),
        ]);
    }

    public function store(UpdateGradeColumn $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->gradeColumns()->create($request->getData());

        return redirect()->back()
            ->with("success", "Dodano kolumnę");
    }

    public function update(UpdateGradeColumn $request, CourseSemester $course, Group $group, GradeColumn $gradeColumn): RedirectResponse
    {
        $gradeColumn->update($request->getData());

        return redirect()->back()
            ->with("success", "Zaktualizowano kolumnę");
    }

    public function storeGrade(UpdateGrade $request, CourseSemester $course, Group $group, GradeColumn $gradeColumn): RedirectResponse
    {
        $gradeColumn->grades()
            ->create($request->getData());

        return redirect()->back();
    }

    public function updateGrade(UpdateGrade $request, CourseSemester $course, Group $group, GradeColumn $gradeColumn): RedirectResponse
    {
        $grade = $gradeColumn->grades()
            ->where("student_id", $request->get("student_id"))
            ->first();

        if ($grade) {
            $grade->update($request->getData());

            return redirect()->back()
                ->with("success", "Zaktualizowano ocenę");
        }

        $gradeColumn->grades()
            ->create($request->getData());

        return redirect()->back();
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
