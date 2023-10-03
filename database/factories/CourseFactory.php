<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ClassType;
use App\Enums\StudyForm;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->asciify("******"),
            "abbreviation" => fake()->asciify("*"),
            "description" => fake()->text,
            "semester" => Semester::factory()->create()->name,
            "type" => ClassType::LABORATORY->value,
            "form" => StudyForm::STATIONARY->value,
        ];
    }
}
