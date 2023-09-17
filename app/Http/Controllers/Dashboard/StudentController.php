<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(): Response
    {
        return inertia("Dashboard/Student/Index", [
            "students" => Student::query()->paginate(),
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

    public function edit(): void
    {
    }

    public function update(): void
    {
    }

    public function destroy(): void
    {
    }
}
