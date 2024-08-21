<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Keating\Models\CourseSemester;
use Keating\Models\Group;
use Keating\Models\Student;
use Keating\Models\User;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->course = CourseSemester::factory()->create();
        $this->actingAs($this->user);
    }

    public function testStudentGroupSemesterCanBeCreated(): void
    {
        $this->post("/dashboard/semester-courses/{$this->course->id}/groups", [
            "name" => "s1INF_1(1)",
            "form" => "stationary",
        ])->assertSessionHasNoErrors();
    }

    public function testStudentGroupCanBeUpdated(): void
    {
        $group = Group::factory()->create();

        $this->assertDatabaseMissing("groups", [
            "name" => "s1INF_1(1)",
            "form" => "stationary",
        ]);

        $this->patch("/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}", [
            "name" => "s1INF_1(1)",
            "form" => "stationary",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("groups", [
            "name" => "s1INF_1(1)",
            "form" => "stationary",
        ]);
    }

    public function testStudentGroupCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/semester-courses/{$this->course->id}/groups", [
            "name" => Str::random(256),
            "form" => "bad-stationary",
        ])->assertSessionHasErrors([
            "name",
            "form",
        ]);

        $this->assertDatabaseCount("groups", 0);
    }

    public function testStudentGroupCanBeDeleted(): void
    {
        $group = Group::factory()->create();
        $this->assertDatabaseCount("groups", 1);

        $this->delete("/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}");

        $this->assertDatabaseCount("groups", 0);
    }

    public function testStudentCanBeAddedToStudentGroup(): void
    {
        $group = Group::factory()->create();
        $student = Student::factory()->create();
        $this->assertCount(0, $group->students);

        $this->post(
            "/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $student->id,
            ],
        )->assertSessionHasNoErrors();

        $group->refresh();
        $this->assertCount(1, $group->students);
    }

    public function testStudentCanBeAddedToStudentGroupOnlyOnce(): void
    {
        $group = Group::factory()->create();
        $student = Student::factory()->create();
        $this->assertCount(0, $group->students);

        $this->post(
            "/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $student->id,
            ],
        )->assertSessionHasNoErrors();

        $group->refresh();
        $this->assertCount(1, $group->students);

        $this->post(
            "/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $student->id,
            ],
        )->assertSessionHasNoErrors();

        $group->refresh();
        $this->assertCount(1, $group->students);
    }

    public function testStudentCanBeRemovedFromStudentGroup(): void
    {
        $group = Group::factory()->create();
        $student = Student::factory()->create();
        $this->assertCount(0, $group->students);

        $this->post(
            "/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $student->id,
            ],
        )->assertSessionHasNoErrors();

        $group->refresh();
        $this->assertCount(1, $group->students);

        $this->delete("/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}/students/{$student->id}");

        $group->refresh();
        $this->assertCount(0, $group->students);
    }

    public function testStudentsAreDetachedBeforeStudentGroupDeleting(): void
    {
        $group = Group::factory()->create();
        $students = Student::factory(10)->create();
        $this->assertCount(0, $group->students);
        $this->assertDatabaseCount("groups", 1);

        $this->post(
            "/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $students->pluck("id"),
            ],
        )->assertSessionHasNoErrors();

        $this->assertDatabaseCount("student_group", 10);

        $this->delete("/dashboard/semester-courses/{$group->course_semester_id}/groups/{$group->id}");

        $this->assertDatabaseCount("student_group", 0);
        $this->assertDatabaseCount("groups", 0);
    }
}
