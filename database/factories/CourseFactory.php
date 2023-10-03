<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ClassType;
use App\Enums\StudyForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->asciify("******"),
            "abbreviation" => fake()->asciify("*"),
            "description" => fake()->text,
            "semester" => fake()->numberBetween(1, 10),
            "type" => ClassType::LABORATORY->value,
            "form" => StudyForm::STATIONARY->value,
        ];
    }
}
