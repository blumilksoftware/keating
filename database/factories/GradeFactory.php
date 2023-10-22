<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\GradeColumn;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    public function definition(): array
    {
        return [
            "value" => fake()->numberBetween(2, 5),
            "status" => fake()->boolean,
            "student_id" => Student::factory(),
            "grade_column_id" => GradeColumn::factory(),
        ];
    }
}
