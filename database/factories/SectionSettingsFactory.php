<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SectionSettingsFactory extends Factory
{
    public function definition(): array
    {
        return [
            "banner_enabled" => fake()->boolean,
            "about_enabled" => fake()->boolean,
            "counters_enabled" => fake()->boolean,
            "contact_enabled" => fake()->boolean,
        ];
    }
}
