<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseSemester;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseSemesterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->semester = Semester::factory()->create();
        $this->course = Course::factory()->create();
        $this->actingAs($this->user);
    }

    public function testCourseSemesterCanBeCreated(): void
    {
        $this->post("/dashboard/semester-courses", [
            "course" => $this->course->id,
            "semester" => $this->semester->id,
        ])->assertSessionHasNoErrors();
    }

    public function testCourseCanBeUpdated(): void
    {
        $course = CourseSemester::factory()->create();

        $this->assertDatabaseMissing("course_semester", [
            "course_id" => $this->course->id,
            "semester_id" => $this->semester->id,
        ]);

        $this->patch("/dashboard/semester-courses/{$course->id}", [
            "course" => $this->course->id,
            "semester" => $this->semester->id,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("course_semester", [
            "course_id" => $this->course->id,
            "semester_id" => $this->semester->id,
        ]);
    }

    public function testCourseCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/semester-courses", [
            "course" => 123,
            "semester" => 312,
        ])->assertSessionHasErrors([
            "course",
            "semester",
        ]);

        $this->assertDatabaseCount("course_semester", 0);
    }

    public function testCourseCanBeDeleted(): void
    {
        $course = CourseSemester::factory()->create();
        $this->assertDatabaseCount("course_semester", 1);

        $this->delete("/dashboard/semester-courses/{$course->id}");

        $this->assertDatabaseCount("course_semester", 0);
    }
}
