<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactInfo>
 */
class ContactInfoFactory extends Factory
{
    public function definition(): array
    {
        return [
            "email" => fake()->unique()->email(),
            "github_handle" => fake()->optional()->url(),
            "alternative_channel" => fake()->optional()->url(),
        ];
    }
}
