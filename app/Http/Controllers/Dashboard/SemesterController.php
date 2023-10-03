<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class SemesterController extends Controller
{
    public function index(): Response
    {
        $semesters = Semester::query()
            ->orderByDesc("created_at")
            ->get();

        return inertia("Dashboard/Semester/Index", [
            "semesters" => $semesters,
            "total" => Semester::query()->count(),
            "lastUpdate" => Semester::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/Semester/Create");
    }

    public function store(SemesterRequest $request): RedirectResponse
    {
        Semester::query()->create($request->validated());

        return redirect()
            ->route("semesters.index")
            ->with("success", "Dodano semestr");
    }

    public function edit(Semester $semester): Response
    {
        return inertia("Dashboard/Semester/Edit", [
            "semester" => $semester,
        ]);
    }

    public function update(SemesterRequest $request, Semester $semester): RedirectResponse
    {
        $semester->update($request->validated());

        return redirect()
            ->route("semesters.index")
            ->with("success", "Zaktualizowano semestr");
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        $semester->delete();

        return redirect()->back()
            ->with("success", "Usunięto semestr");
    }

    public function toggleActive(Semester $semester): RedirectResponse
    {
        $semester->update(["active" => !$semester->active]);

        return redirect()->back()
            ->with("success", "Semestr aktywny");
    }
}
