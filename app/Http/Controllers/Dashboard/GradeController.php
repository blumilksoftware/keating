<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Keating\DTOs\CourseSemesterData;
use Keating\Http\Requests\UpdateGrade;
use Keating\Http\Requests\UpdateGradeColumn;
use Keating\Models\CourseSemester;
use Keating\Models\GradeColumn;
use Keating\Models\Group;

class GradeController
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
            ->orderBy("surname")
            ->paginate(100)
            ->withQueryString();

        return inertia("Dashboard/CourseSemester/Grade/Index", [
            "course" => CourseSemesterData::fromModel($course),
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
