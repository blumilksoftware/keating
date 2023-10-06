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
        $availableStudents = Student::query()->whereNotIn("id", $group->students->pluck("id"))->get();
        $students = $group->students()
            ->when(
                $searchText !== null,
                fn(Builder $query): Builder => $query
                    ->where("name", "ILIKE", "%$searchText%")
                    ->orWhere("surname", "ILIKE", "%$searchText%")
                    ->orWhere("index_number", "LIKE", "%$searchText%"),
            )
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/CourseSemester/Student/Index", [
            "course" => new CourseSemesterResource($course),
            "group" => $group,
            "students" => $students,
            "availableStudents" => $availableStudents,
            "total" => $group->students->count(),
            "lastUpdate" => $group->students->sortBy("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function store(Request $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->students()->attach();

        return redirect()->back()
            ->with("success", "Dodano studenta");
    }

    public function destroy(CourseSemester $course, Group $group): RedirectResponse
    {
        $group->delete();

        return redirect()->back()
            ->with("success", "Usunięto grupę");
    }
}
