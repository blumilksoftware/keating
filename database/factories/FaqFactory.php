<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Keating\Models\Faq;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            "question" => fake()->sentence(),
            "answer" => fake()->realText(),
        ];
    }
}
