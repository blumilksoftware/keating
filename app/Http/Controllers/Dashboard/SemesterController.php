<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\Actions\ActivateSemesterAction;
use Keating\Http\Requests\SemesterRequest;
use Keating\Models\Semester;

class SemesterController
{
    public function index(): Response
    {
        $semesters = Semester::query()
            ->orderByDesc("active")
            ->orderByDesc("created_at")
            ->orderByDesc("id")
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

    public function toggleActive(Semester $semester, ActivateSemesterAction $activateSemesterAction): RedirectResponse
    {
        try {
            $activateSemesterAction->execute($semester);

            return redirect()->back()
                ->with("success", "Semestr aktywny");
        } catch (Exception) {
            return redirect()->back()
                ->with("error", "Wystąpił nieoczekiwany problem");
        }
    }
}
