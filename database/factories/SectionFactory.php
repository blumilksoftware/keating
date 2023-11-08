<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SectionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => fake()->text(20),
            "value" => fake()->text(300),
            "type" => fake()->randomElement(SectionType::cases())->value,
        ];
    }

    public function counter(): static
    {
        return $this->state(fn(array $attributes): array => [
            "title" => fake()->numberBetween(1, 100),
            "value" => fake()->text(30),
            "type" => SectionType::Counter->value,
        ]);
    }

    public function about(): static
    {
        return $this->state(fn(array $attributes): array => [
            "title" => fake()->text(30),
            "value" => fake()->text(300),
            "type" => SectionType::About->value,
        ]);
    }
}
