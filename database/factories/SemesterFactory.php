<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SemesterStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => "Semestr" . fake()->numberBetween(1, 7),
            "status" => fake()->boolean ? SemesterStatus::ACTIVE->value : SemesterStatus::INACTIVE->value,
        ];
    }
}
