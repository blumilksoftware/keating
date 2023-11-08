<?php

declare(strict_types=1);

namespace Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
        ]);

        $this->patch("/dashboard/settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "John Doe",
            "teacher_email" => "john.doe@exmple.com",
            "teacher_titles" => "dr",
            "university_name" => "SWPS",
            "department_name" => "Psychology department",
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
        ]);

        $this->patch("/dashboard/settings", [
            "teacher_name" => Str::random(256),
            "teacher_email" => "john.doe",
            "teacher_titles" => Str::random(256),
            "university_name" => Str::random(256),
            "department_name" => Str::random(256),
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "teacher_name",
                "teacher_email",
                "teacher_titles",
                "university_name",
                "department_name",
            ]);

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
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
        ]);

        $this->patch("/dashboard/settings", [
            "teacher_name" => "",
            "teacher_email" => "",
            "teacher_titles" => "",
            "university_name" => "",
            "department_name" => "",
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "teacher_name",
                "teacher_email",
                "teacher_titles",
                "university_name",
                "department_name",
            ]);

        $this->assertDatabaseHas("settings", [
            "teacher_name" => "Ty Doe",
            "teacher_email" => "ty.doe@exmple.com",
            "teacher_titles" => "dr inż.",
            "university_name" => "CWUP",
            "department_name" => "IT department",
        ]);
    }
}
