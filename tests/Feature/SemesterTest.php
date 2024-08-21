<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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

    public function testManySemestersCanBeActive(): void
    {
        $inactiveSemester = Semester::factory()->create(["active" => 0]);
        $activeSemester = Semester::factory()->create(["active" => 1]);
        $this->assertFalse($inactiveSemester->active);
        $this->assertTrue($activeSemester->active);

        $this->post("/dashboard/semesters/{$inactiveSemester->id}/activate");

        $inactiveSemester->refresh();
        $activeSemester->refresh();
        $this->assertTrue($inactiveSemester->active);
        $this->assertTrue($activeSemester->active);
    }
}
