<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseSemesterResource;
use App\Models\CourseSemester;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class GroupStudentController extends Controller
{
    public function index(Request $request, CourseSemester $course, Group $group): Response
    {
        $searchText = $request->query("search");
        $students = $group->students()
            ->paginate()
            ->withQueryString();
        $availableStudents = $searchText
            ? Student::query()
                ->whereNotIn("id", $group->students->pluck("id"))
                ->where(
                    fn(Builder $query): Builder => $query
                        ->where("first_name", "ILIKE", "%$searchText%")
                        ->orWhere("surname", "ILIKE", "%$searchText%")
                        ->orWhere("index_number", "LIKE", "%$searchText%"),
                )->get()
            : [];

        return inertia("Dashboard/CourseSemester/Student/Index", [
            "course" => new CourseSemesterResource($course),
            "group" => $group,
            "students" => $students,
            "availableStudents" => $availableStudents,
            "search" => $searchText,
            "total" => $group->students->count(),
        ]);
    }

    public function store(Request $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->students()->sync($request->get("student"), false);

        return redirect()->back()
            ->with("success", "Dodano studenta");
    }

    public function destroy(CourseSemester $course, Group $group, Student $student): RedirectResponse
    {
        $group->students()->detach($student);

        return redirect()->back()
            ->with("success", "Usunięto grupę");
    }
}
