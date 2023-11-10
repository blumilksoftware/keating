<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Enums\StudyForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSemesterRequest;
use App\Http\Resources\CourseSemesterResource;
use App\Http\Resources\GroupResource;
use App\Models\Course;
use App\Models\CourseSemester;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Spatie\LaravelOptions\Options;

class CourseSemesterController extends Controller
{
    public function index(): Response
    {
        $courses = CourseSemester::query()
            ->withCount("groups")
            ->orderBy("created_at")
            ->get();

        return inertia("Dashboard/CourseSemester/Index", [
            "courses" => CourseSemesterResource::collection($courses),
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
            "course" => new CourseSemesterResource($course->load("groups")),
            "groups" => GroupResource::collection($course->groups),
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
