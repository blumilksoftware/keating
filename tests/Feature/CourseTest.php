<?php

declare(strict_types=1);

namespace Feature;

use App\Models\Course;
use App\Models\Field;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Field $field;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->field = Field::factory()->create();
        $this->actingAs($this->user);
    }

    public function testCourseCanBeCreated(): void
    {
        $this->post("/dashboard/courses", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
            "field_id" => $this->field->id,
        ])->assertSessionHasNoErrors();
    }

    public function testCourseCanBeUpdated(): void
    {
        $course = Course::factory()->create();

        $this->assertDatabaseMissing("courses", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
            "field_id" => $this->field->id,
        ]);

        $this->patch("/dashboard/courses/{$course->id}", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
            "field_id" => $this->field->id,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("courses", [
            "name" => "Course",
            "abbreviation" => "C",
            "semester" => 2,
            "type" => "laboratory",
            "field_id" => $this->field->id,
        ]);
    }

    public function testCourseCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/courses", [
            "name" => Str::random(256),
            "abbreviation" => Str::random(256),
            "semester" => "bad",
            "type" => "lab",
            "field_id" => 0,
        ])->assertSessionHasErrors([
            "name",
            "abbreviation",
            "semester",
            "type",
            "field_id",
        ]);

        $this->assertDatabaseCount("courses", 0);
    }

    public function testCourseCanBeDeleted(): void
    {
        $course = Course::factory()->create();
        $this->assertDatabaseCount("courses", 1);

        $this->delete("/dashboard/courses/{$course->id}");

        $this->assertDatabaseCount("courses", 0);
    }
}
