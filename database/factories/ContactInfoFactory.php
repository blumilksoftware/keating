<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Icons;
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
            "label" => fake()->domainWord(),
            "link" => fake()->url(),
            "icon" => fake()->randomElement(Icons::class),
        ];
    }
}
