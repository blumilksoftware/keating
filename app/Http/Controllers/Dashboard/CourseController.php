<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class CourseController extends Controller
{
    public function index(): Response
    {
        $courses = Course::query()
            ->orderBy("semester")
            ->get();

        return inertia("Dashboard/Course/Index", [
            "courses" => $courses,
            "total" => Course::query()->count(),
            "lastUpdate" => Course::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/Course/Create");
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
        return inertia("Dashboard/Course/Edit", [
            "course" => $course,
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
