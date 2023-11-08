<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionSettings;
use App\Models\Setting;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        /** @var Setting $settings */
        $settings = Setting::query()->first();

        return inertia("Public/Home", [
            "title" => $settings->teacher_titles,
            "name" => $settings->teacher_name,
            "email" => $settings->teacher_email,
            "department" => $settings->department_name,
            "university" => $settings->university_name,
            "universityLogo" => "https://irg2023.collegiumwitelona.pl/assets/logos/cwup.png",
            "sectionSettings" => SectionSettings::query()->first(),
            "about" => Section::query()->about()->get(),
            "counters" => Section::query()->counter()->get(),
        ]);
    }
}
