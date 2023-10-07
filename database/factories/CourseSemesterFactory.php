<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\StudyForm;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseSemesterFactory extends Factory
{
    public function definition(): array
    {
        return [
            "semester_id" => Semester::factory(),
            "course_id" => Course::factory(),
            "form" => StudyForm::Stationary->value,
        ];
    }
}
