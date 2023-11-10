<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->name();

        return [
            "title" => $title,
            "slug" => Str::slug($title),
            "content" => fake()->realText(),
            "published_at" => Carbon::now(),
        ];
    }
}
