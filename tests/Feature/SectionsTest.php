<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Section;
use App\Models\SectionSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SectionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testSectionCanBeCreated(): void
    {
        $this->assertDatabaseEmpty("sections");

        $this->post("/dashboard/sections", [
            "title" => "About me",
            "value" => "Lorem ipsum",
            "type" => "about",
        ])->assertSessionHasNoErrors()
            ->assertValid([
                "title",
                "value",
                "type",
            ]);

        $this->assertDatabaseHas("sections", [
            "title" => "About me",
            "value" => "Lorem ipsum",
            "type" => "about",
        ]);
    }

    public function testSectionCannotBeCreatedWithInvalidData(): void
    {
        $this->assertDatabaseEmpty("sections");

        $this->post("/dashboard/sections", [
            "title" => Str::random(256),
            "value" => Str::random(65001),
            "type" => "invalid-about",
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "title",
                "value",
                "type",
            ]);

        $this->assertDatabaseEmpty("sections");
    }

    public function testSectionCannotBeCreatedWithInvalidType(): void
    {
        $this->assertDatabaseEmpty("sections");

        $this->post("/dashboard/sections", [
            "title" => Str::random(255),
            "value" => Str::random(65000),
            "type" => "invalid",
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "type",
            ]);

        $this->assertDatabaseEmpty("sections");
    }

    public function testSectionCanBeUpdated(): void
    {
        $section = Section::factory()->create();

        $this->assertDatabaseHas("sections", [
            "title" => $section->title,
            "value" => $section->value,
            "type" => $section->type->value,
        ]);

        $this->patch("/dashboard/sections/{$section->id}", [
            "title" => "About me",
            "value" => "Lorem ipsum",
            "type" => "about",
        ])->assertSessionHasNoErrors()
            ->assertValid([
                "title",
                "value",
                "type",
            ]);

        $this->assertDatabaseHas("sections", [
            "title" => "About me",
            "value" => "Lorem ipsum",
            "type" => "about",
        ]);
    }

    public function testSectionCanBeDeleted(): void
    {
        $section = Section::factory()->create();

        $this->assertDatabaseCount("sections", 1);

        $this->delete("/dashboard/sections/{$section->id}")
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount("sections", 0);
    }

    public function testSectionSettingsCanBeUpdated(): void
    {
        SectionSettings::factory()->create([
            "banner_enabled" => true,
            "about_enabled" => true,
            "counters_enabled" => true,
            "contact_enabled" => true,
        ]);

        $this->assertDatabaseHas("section_settings", [
            "banner_enabled" => true,
            "about_enabled" => true,
            "counters_enabled" => true,
            "contact_enabled" => true,
        ]);

        $this->patch("/dashboard/section-settings", [
            "banner_enabled" => false,
            "about_enabled" => false,
            "counters_enabled" => false,
            "contact_enabled" => false,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("section_settings", [
            "banner_enabled" => false,
            "about_enabled" => false,
            "counters_enabled" => false,
            "contact_enabled" => false,
        ]);
    }
}
