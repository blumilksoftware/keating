<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Keating\Models\Semester;
use Keating\Models\User;
use Tests\TestCase;

class SemesterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testSemesterCanBeCreated(): void
    {
        $this->assertDatabaseCount("semesters", 0);

        $this->post("/dashboard/semesters", [
            "name" => "Semester 1",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("semesters", 1);
    }

    public function testSemesterCanBeUpdated(): void
    {
        $semester = Semester::factory()->create();

        $this->assertDatabaseMissing("semesters", [
            "name" => "Semester 1",
        ]);

        $this->patch("/dashboard/semesters/{$semester->id}", [
            "name" => "Semester 1",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("semesters", [
            "name" => "Semester 1",
        ]);
    }

    public function testSemesterCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/semesters", [
            "name" => Str::random(256),
        ])->assertSessionHasErrors([
            "name",
        ]);

        $this->assertDatabaseCount("semesters", 0);
    }

    public function testSemesterCanBeDeleted(): void
    {
        $semester = Semester::factory()->create();
        $this->assertDatabaseCount("semesters", 1);

        $this->delete("/dashboard/semesters/{$semester->id}");

        $this->assertDatabaseCount("semesters", 0);
    }

    public function testSemesterCanBeSetToActiveStatus(): void
    {
        $semester = Semester::factory()->create(["active" => 0]);
        $this->assertFalse($semester->active);

        $this->post("/dashboard/semesters/{$semester->id}/activate");

        $semester->refresh();
        $this->assertTrue($semester->active);
    }

    public function testManySemestersCannotBeActive(): void
    {
        $oldSemester = Semester::factory()->create(["active" => 0]);
        $previousSemester = Semester::factory()->create(["active" => 0]);
        $currentSemester = Semester::factory()->create(["active" => 0]);

        $this->assertFalse($oldSemester->active);
        $this->assertFalse($previousSemester->active);
        $this->assertFalse($currentSemester->active);

        $this->post("/dashboard/semesters/{$currentSemester->id}/activate");

        $oldSemester->refresh();
        $previousSemester->refresh();
        $currentSemester->refresh();

        $this->assertFalse($oldSemester->active);
        $this->assertFalse($previousSemester->active);
        $this->assertTrue($currentSemester->active);

        $newSemester = Semester::factory()->create(["active" => 0]);
        $this->post("/dashboard/semesters/{$newSemester->id}/activate");

        $oldSemester->refresh();
        $previousSemester->refresh();
        $currentSemester->refresh();
        $newSemester->refresh();

        $this->assertFalse($oldSemester->active);
        $this->assertFalse($previousSemester->active);
        $this->assertFalse($currentSemester->active);
        $this->assertTrue($newSemester->active);
    }
}
