<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Keating\Models\Setting;
use Keating\Models\User;
use Tests\TestCase;

class SettingsScheduleLinkTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testMainPageWhenNoScheduleLinkInSetting(): void
    {
        Setting::factory()->create([
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => null,
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
        ]);

        $this->get("/")->assertInertia(function (AssertableInertia $page): void {
            $page->has("settings")->where("settings.scheduleLink", null);
        });
    }

    public function testMainPageWhenScheduleLinkInSetting(): void
    {
        Setting::factory()->create([
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
        ]);

        $this->get("/")->assertInertia(function (AssertableInertia $page): void {
            $page->has("settings")->where("settings.scheduleLink", "https://google.com/");
        });
    }
}
