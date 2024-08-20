<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Keating\Enums\ClassType;

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
