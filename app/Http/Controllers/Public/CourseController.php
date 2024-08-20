<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoursePublicResource as CourseResource;
use App\Models\Course;
use App\Models\Semester;
use Inertia\Response;

class CourseController extends Controller
{
    public function index(): Response
    {
        $activeSemesters = Semester::query()
            ->where("active", true)
            ->pluck("name");

        $courses = Course::query()->get()
            ->map(fn(Course $course): array => (new CourseResource($course, $activeSemesters))->resolve())
            ->sortBy("semester")
            ->sortByDesc("active");

        return inertia("Public/Course/Index", [
            "courses" => $courses->values(),
        ]);
    }

    public function get(string $id): Response
    {
        $course = Course::query()
            ->where("id", $id)
            ->firstOrFail();

        return inertia("Public/Course/Course", [
            "course" => new CourseResource($course, collect()),
        ]);
    }
}
