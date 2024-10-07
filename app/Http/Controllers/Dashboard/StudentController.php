<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Keating\Actions\WuStudentsImport;
use Keating\Http\Requests\StoreStudentRequest;
use Keating\Http\Requests\UpdateStudentRequest;
use Keating\Models\Student;

class StudentController
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
            ->orderBy("surname")
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

    public function import(): Response
    {
        return inertia("Dashboard/Student/Import");
    }

    public function storeMany(Request $request, WuStudentsImport $importer): RedirectResponse
    {
        $importer->import($request->get("content") ?? "");
        $importer->save();

        return redirect()
            ->route("students.index")
            ->with("success", "Dodano studentów");
    }
}
