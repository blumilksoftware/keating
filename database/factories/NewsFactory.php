<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected const array NEWS_TITLES = [
        "Odwołane zajęcia",
        "Przeniesione zajęcia",
        "Nieobecność",
        "Początek roku akademickiego",
        "Koniec roku akademickiego",
        "Terminy egzaminów",
    ];

    public function definition(): array
    {
        $title = fake()->randomElement(static::NEWS_TITLES);

        return [
            "title" => $title,
            "content" => fake()->realText(),
            "published_at" => fake()->dateTimeThisYear(),
        ];
    }
}
