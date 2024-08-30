<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Inertia\Response;
use Keating\DTOs\ContactInfoData;
use Keating\Models\ContactInfo;
use Keating\Models\Setting;

class ContactController
{
    public function __invoke(): Response
    {
        /** @var Setting $settings */
        $settings = Setting::query()->first();
        $contactInfos = ContactInfo::query()->get();

        return inertia("Public/Contact", [
            "title" => $settings->teacher_titles,
            "name" => $settings->teacher_name,
            "email" => $settings->teacher_email,
            "department" => $settings->department_name,
            "university" => $settings->university_name,
            "universityLogo" => asset("cwup-full.png"),
            "contactInfos" => $contactInfos->map(fn(ContactInfo $contactInfo): ContactInfoData => ContactInfoData::fromModel($contactInfo)),
        ]);
    }
}