<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Keating\Enums\StudyForm;
use Keating\Models\CourseSemester;

class GroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->numerify("s#INF#"),
            "course_semester_id" => CourseSemester::factory(),
            "form" => StudyForm::Stationary->value,
        ];
    }
}
