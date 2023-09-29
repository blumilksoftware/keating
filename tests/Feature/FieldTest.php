<?php

declare(strict_types=1);

namespace Feature;

use App\Models\Field;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class FieldTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testFieldCanBeCreated(): void
    {
        $this->assertDatabaseCount("fields", 0);

        $this->post("/dashboard/fields", [
            "name" => "Field 1",
            "abbreviation" => "F",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("fields", 1);
    }

    public function testFieldCanBeUpdated(): void
    {
        $semester = Field::factory()->create();

        $this->assertDatabaseMissing("fields", [
            "name" => "Field 1",
            "abbreviation" => "F",
        ]);

        $this->patch("/dashboard/fields/{$semester->id}", [
            "name" => "Field 1",
            "abbreviation" => "F",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("fields", [
            "name" => "Field 1",
            "abbreviation" => "F",
        ]);
    }

    public function testFieldCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/fields", [
            "name" => Str::random(256),
            "abbreviation" => Str::random(256),
        ])->assertSessionHasErrors([
            "name",
        ]);

        $this->assertDatabaseCount("fields", 0);
    }

    public function testFieldCanBeDeleted(): void
    {
        $semester = Field::factory()->create();
        $this->assertDatabaseCount("fields", 1);

        $this->delete("/dashboard/fields/{$semester->id}");

        $this->assertDatabaseCount("fields", 0);
    }
}
