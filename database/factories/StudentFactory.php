<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "surname" => fake()->lastName(),
            "index_number" => fake()->unique()->numberBetween(1, 10000),
        ];
    }
}
