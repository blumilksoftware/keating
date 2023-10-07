<?php

declare(strict_types=1);

namespace Feature;

use App\Models\CourseSemester;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
        $this->post("/dashboard/course-semester/{$this->course->id}/groups", [
            "name" => "s1INF_1(1)",
        ])->assertSessionHasNoErrors();
    }

    public function testStudentGroupCanBeUpdated(): void
    {
        $group = Group::factory()->create();

        $this->assertDatabaseMissing("groups", [
            "name" => "s1INF_1(1)",
        ]);

        $this->patch("/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}", [
            "name" => "s1INF_1(1)",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("groups", [
            "name" => "s1INF_1(1)",
        ]);
    }

    public function testStudentGroupCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/course-semester/{$this->course->id}/groups", [
            "name" => Str::random(256),
        ])->assertSessionHasErrors([
            "name",
        ]);

        $this->assertDatabaseCount("groups", 0);
    }

    public function testStudentGroupCanBeDeleted(): void
    {
        $group = Group::factory()->create();
        $this->assertDatabaseCount("groups", 1);

        $this->delete("/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}");

        $this->assertDatabaseCount("groups", 0);
    }

    public function testStudentCanBeAddedToStudentGroup(): void
    {
        $group = Group::factory()->create();
        $student = Student::factory()->create();
        $this->assertCount(0, $group->students);

        $this->post(
            "/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}/students",
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
            "/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $student->id,
            ],
        )->assertSessionHasNoErrors();

        $group->refresh();
        $this->assertCount(1, $group->students);

        $this->post(
            "/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}/students",
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
            "/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $student->id,
            ],
        )->assertSessionHasNoErrors();

        $group->refresh();
        $this->assertCount(1, $group->students);

        $this->delete("/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}/students/{$student->id}");

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
            "/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}/students",
            [
                "student" => $students->pluck("id"),
            ],
        )->assertSessionHasNoErrors();

        $this->assertDatabaseCount("student_group", 10);

        $this->delete("/dashboard/course-semester/{$group->course_semester_id}/groups/{$group->id}");

        $this->assertDatabaseCount("student_group", 0);
        $this->assertDatabaseCount("groups", 0);
    }
}
