<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Keating\Models\Section;
use Keating\Models\SectionSettings;
use Keating\Models\Setting;
use Keating\Models\User;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(["email" => "admin@example.com"]);

        Setting::factory()->create();
        SectionSettings::query()->create([
            "banner_enabled" => true,
            "about_enabled" => true,
            "counters_enabled" => true,
            "contact_enabled" => true,
        ]);
    }
}
