<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Keating\Models\Course;
use Keating\Models\User;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testCourseCanBeCreated(): void
    {
        $this->post("/dashboard/courses", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
        ])->assertSessionHasNoErrors();
    }

    public function testCourseCanBeUpdated(): void
    {
        $semester = Course::factory()->create();

        $this->assertDatabaseMissing("courses", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
        ]);

        $this->patch("/dashboard/courses/{$semester->id}", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("courses", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
        ]);
    }

    public function testCourseCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/courses", [
            "name" => Str::random(256),
            "abbreviation" => Str::random(256),
            "semester" => "bad",
            "type" => "lab",
        ])->assertSessionHasErrors([
            "name",
            "abbreviation",
            "semester",
            "type",
        ]);

        $this->assertDatabaseCount("courses", 0);
    }

    public function testCourseCanBeDeleted(): void
    {
        $semester = Course::factory()->create();
        $this->assertDatabaseCount("courses", 1);

        $this->delete("/dashboard/courses/{$semester->id}");

        $this->assertDatabaseCount("courses", 0);
    }
}
