<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CourseSemester;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->asciify("******"),
            "course_semester_id" => CourseSemester::factory(),
        ];
    }
}
