<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Semester;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SemesterTest extends TestCase
{
    use RefreshDatabase;

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
}
