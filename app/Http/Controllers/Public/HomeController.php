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
        /** @var SectionSettings $sectionSettings */
        $sectionSettings = SectionSettings::query()->first();

        return inertia("Public/Home", [
            "title" => $settings->teacher_titles,
            "name" => $settings->teacher_name,
            "email" => $settings->teacher_email,
            "department" => $settings->department_name,
            "university" => $settings->university_name,
            "universityLogo" => asset("cwup-full.png"),
            "sectionSettings" => $sectionSettings,
            "about" => $sectionSettings->about_enabled ? Section::query()->about()->orderBy("created_at")->get() : [],
            "counters" => $sectionSettings->counters_enabled ? Section::query()->counter()->orderBy("created_at")->get() : [],
        ]);
    }
}
