<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Keating\Models\CourseSemester;
use Keating\Models\Grade;
use Keating\Models\GradeColumn;
use Keating\Models\Group;
use Keating\Models\SectionSettings;
use Keating\Models\Setting;
use Keating\Models\Student;
use Tests\TestCase;

class GradePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::factory()->create();
        SectionSettings::factory()->create();
        $this->course = CourseSemester::factory()->create();
        $this->student = Student::factory()->create();
        $this->group = Group::factory()->create([
            "course_semester_id" => $this->course->id,
        ]);
        $this->group->students()->sync($this->student);
        $column = GradeColumn::factory()->create([
            "group_id" => $this->group->id,
            "active" => true,
        ]);
        Grade::factory()->create([
            "grade_column_id" => $column->id,
            "student_id" => $this->student->id,
        ]);
    }

    public function testTheGradePageReturnsSuccessfulResponse(): void
    {
        $this->get("/oceny")->assertStatus(200);
    }

    public function testOnTheGradePageCanChooseSemester(): void
    {
        $this->get("/oceny")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester", null),
            );

        $this->get("/oceny/{$this->course->semester_id}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id),
            );
    }

    public function testOnTheGradePageCanChooseCourse(): void
    {
        $this->get("/oceny/{$this->course->semester_id}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course", null),
            );

        $this->get("/oceny/{$this->course->semester_id}/{$this->course->id}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course.id", $this->course->id),
            );
    }

    public function testOnTheGradePageCanChooseGroup(): void
    {
        $this->get("/oceny/{$this->course->semester_id}/{$this->course->id}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course.id", $this->course->id)
                    ->has("groups", 1)
                    ->where("group", null),
            );

        $this->get("/oceny/{$this->course->semester_id}/{$this->course->id}/{$this->group->id}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course.id", $this->course->id)
                    ->has("groups", 1)
                    ->where("group.id", $this->group->id),
            );
    }

    public function testOnTheGradePageCanSeeGradesAfterFillIndexNumber(): void
    {
        $this->get("/oceny/{$this->course->semester_id}/{$this->course->id}/{$this->group->id}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course.id", $this->course->id)
                    ->has("groups", 1)
                    ->where("group.id", $this->group->id)
                    ->where("index", ""),
            );

        $this->get("/oceny/{$this->course->semester_id}/{$this->course->id}/{$this->group->id}/{$this->student->index_number}")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course.id", $this->course->id)
                    ->has("groups", 1)
                    ->where("group.id", $this->group->id)
                    ->where("index", "{$this->student->index_number}")
                    ->has("gradeColumns", 1)
                    ->has("students", 1),
            );
    }

    public function testOnTheGradePageCannotSeeGradesWithInvalidIndexNumber(): void
    {
        $this->get("/oceny/{$this->course->semester_id}/{$this->course->id}/{$this->group->id}/invalid")
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Public/Grade")
                    ->has("semesters", 1)
                    ->where("semester.id", $this->course->semester_id)
                    ->has("courses", 1)
                    ->where("course.id", $this->course->id)
                    ->has("groups", 1)
                    ->where("group.id", $this->group->id)
                    ->where("index", "invalid")
                    ->has("gradeColumns", 0)
                    ->has("students", 0),
            );
    }
}
