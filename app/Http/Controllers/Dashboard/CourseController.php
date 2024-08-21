<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\DTOs\CourseData;
use Keating\DTOs\FieldData;
use Keating\Enums\ClassType;
use Keating\Enums\SemesterName;
use Keating\Enums\StudyForm;
use Keating\Http\Requests\CourseRequest;
use Keating\Models\Course;
use Keating\Models\Field;
use Spatie\LaravelOptions\Options;

class CourseController
{
    public function index(): Response
    {
        $courses = Course::query()
            ->orderBy("semester")
            ->get();

        return inertia("Dashboard/Course/Index", [
            "courses" => $courses->map(fn(Course $course): CourseData => CourseData::fromModel($course)),
            "total" => Course::query()->count(),
            "lastUpdate" => Course::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        $fields = Field::query()
            ->orderBy("abbreviation")
            ->get();

        return inertia("Dashboard/Course/Create", [
            "classTypes" => Options::forEnum(ClassType::class)->toArray(),
            "studyForms" => Options::forEnum(StudyForm::class)->toArray(),
            "semesterNames" => Options::forEnum(SemesterName::class)->toArray(),
            "fields" => $fields->map(fn(Field $field) => FieldData::fromModel($field)),
        ]);
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        Course::query()->create($request->validated());

        return redirect()
            ->route("courses.index")
            ->with("success", "Dodano kurs");
    }

    public function edit(Course $course): Response
    {
        $fields = Field::query()
            ->orderBy("abbreviation")
            ->get();

        return inertia("Dashboard/Course/Edit", [
            "course" => $course,
            "classTypes" => Options::forEnum(ClassType::class)->toArray(),
            "studyForms" => Options::forEnum(StudyForm::class)->toArray(),
            "semesterNames" => Options::forEnum(SemesterName::class)->toArray(),
            "fields" => $fields->map(fn(Field $field) => FieldData::fromModel($field)),
        ]);
    }

    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        return redirect()
            ->route("courses.index")
            ->with("success", "Zaktualizowano kurs");
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->back()
            ->with("success", "Usunięto kurs");
    }
}
