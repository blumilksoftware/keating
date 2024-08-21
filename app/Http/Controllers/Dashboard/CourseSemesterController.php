<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\DTOs\CourseSemesterData;
use Keating\DTOs\GroupData;
use Keating\Enums\StudyForm;
use Keating\Http\Requests\CourseSemesterRequest;
use Keating\Models\Course;
use Keating\Models\CourseSemester;
use Keating\Models\Semester;
use Spatie\LaravelOptions\Options;

class CourseSemesterController
{
    public function index(): Response
    {
        $courses = CourseSemester::query()
            ->withCount("groups")
            ->orderBy("created_at")
            ->get();

        return inertia("Dashboard/CourseSemester/Index", [
            "courses" => $courses->map(fn(CourseSemester $course): CourseSemesterData => CourseSemesterData::fromModel($course)),
            "activeSemester" => Semester::getActive(),
            "total" => Course::query()->count(),
            "lastUpdate" => CourseSemester::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/CourseSemester/Create", [
            "courses" => Course::all(["id", "name"]),
            "semesters" => Semester::all(["id", "name"]),
        ]);
    }

    public function store(CourseSemesterRequest $request): RedirectResponse
    {
        CourseSemester::query()->create($request->getData());

        return redirect()
            ->route("course.semester.index")
            ->with("success", "Dodano kurs");
    }

    public function show(CourseSemester $course): Response
    {
        return inertia("Dashboard/CourseSemester/Show", [
            "course" => CourseSemesterData::fromModel($course),
            "groups" => $course->groups->map(fn($group): GroupData => GroupData::fromModel($group)),
            "studyForms" => Options::forEnum(StudyForm::class)->toArray(),
        ]);
    }

    public function edit(CourseSemester $course): Response
    {
        return inertia("Dashboard/CourseSemester/Edit", [
            "course" => $course,
            "studyForms" => Options::forEnum(StudyForm::class)->toArray(),
            "courses" => Course::all(["id", "name"]),
            "semesters" => Semester::all(["id", "name"]),
        ]);
    }

    public function update(CourseSemesterRequest $request, CourseSemester $course): RedirectResponse
    {
        $course->update($request->getData());

        return redirect()
            ->route("course.semester.index")
            ->with("success", "Zaktualizowano kurs");
    }

    public function destroy(CourseSemester $course): RedirectResponse
    {
        $course->delete();

        return redirect()->back()
            ->with("success", "Usunięto kurs");
    }
}
