<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->randomElement(["zimowy", "letni"]) . " " . fake()->year(),
            "active" => fake()->boolean,
        ];
    }
}
