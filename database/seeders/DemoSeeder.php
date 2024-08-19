<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        News::factory(20)->create();
    }
}
