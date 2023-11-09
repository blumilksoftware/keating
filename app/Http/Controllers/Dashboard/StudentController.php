<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(Request $request): Response
    {
        $searchText = $request->query("search");
        $students = Student::query()
            ->when(
                $searchText !== null,
                fn(Builder $query): Builder => $query
                    ->whereLikeUnaccentInsensitive("first_name", $searchText)
                    ->orWhereLikeUnaccentInsensitive("surname", $searchText)
                    ->orWhere("index_number", "LIKE", "%$searchText%"),
            )
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/Student/Index", [
            "students" => $students,
            "total" => Student::query()->count(),
            "lastUpdate" => Student::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/Student/Create");
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        Student::query()->create($request->validated());

        return redirect()
            ->route("students.index")
            ->with("success", "Dodano studenta");
    }

    public function edit(Student $student): Response
    {
        return inertia("Dashboard/Student/Edit", [
            "student" => $student,
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());

        return redirect()
            ->route("students.index")
            ->with("success", "Zaktualizowano studenta");
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->back()
            ->with("success", "Usunięto studenta");
    }
}
