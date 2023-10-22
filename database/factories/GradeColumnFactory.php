<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeColumnFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->asciify("***"),
            "active" => fake()->boolean,
            "priority" => fake()->numberBetween(1, 100),
            "group_id" => Group::factory(),
        ];
    }
}
