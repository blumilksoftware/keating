<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Keating\DTOs\CourseSemesterData;
use Keating\Models\CourseSemester;
use Keating\Models\Group;
use Keating\Models\Student;

class GroupStudentController
{
    public function index(Request $request, CourseSemester $course, Group $group): Response
    {
        $searchText = $request->query("search");
        $students = $group->students()
            ->paginate()
            ->withQueryString();

        $availableStudents = match(true) {
            $searchText === null => [],
            preg_match("/^(\d+\s?)+$/", $searchText) === 1 => Student::query()
                ->whereNotIn("id", $group->students->pluck("id"))
                ->whereIn("index_number", explode(" ", $searchText))
                ->get(),
            default => Student::query()
                ->whereNotIn("id", $group->students->pluck("id"))
                ->where(
                    fn(Builder $query): Builder => $query
                        ->where("first_name", "ILIKE", "%$searchText%")
                        ->orWhere("surname", "ILIKE", "%$searchText%")
                        ->orWhere("index_number", "LIKE", "%$searchText%"),
                )->get(),
        };

        return inertia("Dashboard/CourseSemester/Student/Index", [
            "course" => CourseSemesterData::fromModel($course),
            "group" => $group,
            "students" => $students,
            "availableStudents" => $availableStudents,
            "search" => $searchText,
            "total" => $group->students->count(),
        ]);
    }

    public function store(Request $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->students()->sync(ids: $request->get("student"), detaching: false);

        return redirect()->back()
            ->with("success", "Dodano studenta");
    }

    public function destroy(CourseSemester $course, Group $group, Student $student): RedirectResponse
    {
        $student->grades()->where("student_id", $student->id)->get()->each->delete();
        $group->students()->detach($student);

        return redirect()->back()
            ->with("success", "Usunięto grupę");
    }
}
