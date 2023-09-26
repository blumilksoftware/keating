<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fake()->asciify("******"),
            "abbreviation" => fake()->asciify("*"),
        ];
    }
}
