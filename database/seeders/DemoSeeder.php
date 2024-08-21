<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Keating\Models\News;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        News::factory(20)->create();
    }
}
