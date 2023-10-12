<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ClassType;
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
            "type" => ClassType::Laboratory->value,
        ];
    }
}
