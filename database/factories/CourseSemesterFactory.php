<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Keating\Models\Course;
use Keating\Models\Semester;

class CourseSemesterFactory extends Factory
{
    public function definition(): array
    {
        return [
            "semester_id" => Semester::factory(),
            "course_id" => Course::factory(),
        ];
    }
}
