<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Inertia\Response;
use Keating\Http\Resources\CoursePublicResource as CourseResource;
use Keating\Models\Course;
use Keating\Models\Semester;

class CourseController
{
    public function index(): Response
    {
        $activeSemesters = Semester::query()
            ->where("active", true)
            ->pluck("name");

        $courses = Course::query()
            ->with("field")
            ->get()
            ->map(fn(Course $course): array => (new CourseResource($course, $activeSemesters))->resolve())
            ->sortBy("semester")
            ->sortByDesc("active");

        return inertia("Public/Course/Index", [
            "courses" => $courses->values(),
        ]);
    }

    public function get(string $slug): Response
    {
        $course = Course::query()
            ->where("slug", $slug)
            ->firstOrFail();

        return inertia("Public/Course/Course", [
            "course" => new CourseResource($course, collect()),
        ]);
    }
}
