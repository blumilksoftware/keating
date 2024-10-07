<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Keating\Models\Group;

class GradeColumnFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->numerify("W#"),
            "active" => fake()->boolean,
            "priority" => fake()->numberBetween(1, 100),
            "group_id" => Group::factory(),
        ];
    }
}
