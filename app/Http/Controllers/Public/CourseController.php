<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Inertia\Response;
use Keating\DTOs\CoursePublicData;
use Keating\Models\Course;

class CourseController
{
    public function index(): Response
    {
        $courses = Course::query()
            ->with("field")
            ->get()
            ->map(fn(Course $course): CoursePublicData => CoursePublicData::fromModel($course))
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
            "course" => CoursePublicData::fromModel($course),
        ]);
    }
}
