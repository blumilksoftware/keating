<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Keating\Models\Setting;
use Keating\Models\User;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
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
        $this->actingAs($this->user);
    }

    public function testSettingsCanBeUpdated(): void
    {
        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);

        $this->post("/dashboard/settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#11ffff",
            "secondary_color" => "#110000",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#11ffff",
            "secondary_color" => "#110000",
            "logo" => null,
        ]);
    }

    public function testSettingsCannotBeUpdatedWithInvalidData(): void
    {
        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);

        $this->post("/dashboard/settings", [
            "teacher_name" => Str::random(256),
            "teacher_email" => "john.doe",
            "teacher_titles" => Str::random(256),
            "university_name" => Str::random(256),
            "department_name" => Str::random(256),
            "schedule_link" => "test",
            "primary_color" => "000000",
            "secondary_color" => "ffffff",
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "teacher_name",
                "teacher_email",
                "teacher_titles",
                "university_name",
                "department_name",
                "schedule_link",
                "primary_color",
                "secondary_color",
            ]);

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);
    }

    public function testSettingsCannotBeUpdatedWithEmptyData(): void
    {
        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);

        $this->post("/dashboard/settings", [
            "teacher_name" => "",
            "teacher_email" => "",
            "teacher_titles" => "",
            "university_name" => "",
            "department_name" => "",
            "primary_color" => "",
            "secondary_color" => "",
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "teacher_name",
                "teacher_email",
                "teacher_titles",
                "university_name",
                "department_name",
                "primary_color",
                "secondary_color",
            ]);

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);
    }

    public function testLogoCanBeUploadedAndRemoved(): void
    {
        Storage::fake("public");
        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);
        $logo = UploadedFile::fake()->image("logo.png");

        $this->post("/dashboard/settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#11ffff",
            "secondary_color" => "#110000",
            "logo" => $logo,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#11ffff",
            "secondary_color" => "#110000",
            "logo" => "logo/logo.png",
        ]);

        Storage::disk("public")->assertExists("logo/logo.png");

        $this->delete("/dashboard/settings/remove-logo")->assertSessionHasNoErrors();

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#11ffff",
            "secondary_color" => "#110000",
            "logo" => null,
        ]);

        Storage::disk("public")->assertMissing("logo/logo.png");
    }

    public function testSettingsCannotBeUpdatedWithTooBigLogoFile(): void
    {
        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);
        $logo = UploadedFile::fake()->image("logo.png")->size(2049);

        $this->post("/dashboard/settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#11ffff",
            "secondary_color" => "#110000",
            "logo" => $logo,
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "logo",
            ]);

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
            "schedule_link" => "https://google.com/",
            "primary_color" => "#000000",
            "secondary_color" => "#ffffff",
            "logo" => null,
        ]);
    }
}
