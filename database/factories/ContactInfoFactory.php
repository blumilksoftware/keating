<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Keating\Models\ContactInfo;

/**
 * @extends Factory<ContactInfo>
 */
class ContactInfoFactory extends Factory
{
    public function definition(): array
    {
        return [
            "label" => fake()->domainWord(),
            "identifier" => fake()->url(),
        ];
    }
}
