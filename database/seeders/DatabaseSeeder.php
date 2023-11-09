<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Section;
use App\Models\SectionSettings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(["email" => "admin@example.com"]);
        Setting::factory()->create();
        Section::factory(4)->counter()->create();
        Section::factory(3)->about()->create();
        SectionSettings::query()->create([
            "banner_enabled" => true,
            "about_enabled" => true,
            "counters_enabled" => true,
            "contact_enabled" => true,
        ]);
    }
}
