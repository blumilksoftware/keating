<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            "teacher_titles" => "dr",
            "teacher_name" => fake()->name,
            "teacher_email" => fake()->email,
            "department_name" => "Zakład Informatyki, Wydział Nauk Technicznych i Ekonomicznych",
            "university_name" => "Collegium Witelona Uczelnia Państwowa",
        ];
    }
}
