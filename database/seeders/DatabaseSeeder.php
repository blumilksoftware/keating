<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ContactInfo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(1)->create([
            "email" => "user@example.com",
        ]);

        ContactInfo::factory(1)->create();
    }
}
