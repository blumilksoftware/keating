<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Keating\Models\Grade;
use Keating\Models\GradeColumn;
use Keating\Models\Student;
use Keating\Models\User;
use Tests\TestCase;

class GradeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->student = Student::factory()->create();
        $this->gradeColumn = GradeColumn::factory()->create();
        $this->actingAs($this->user);
    }

    public function testGradeCanBeCreated(): void
    {
        $this->assertDatabaseCount("grades", 0);

        $this->post("/dashboard/semester-courses/{$this->gradeColumn->group->course_semester_id}/groups/{$this->gradeColumn->group->id}/grades/{$this->gradeColumn->id}/store", [
            "student_id" => $this->student->id,
            "status" => true,
            "value" => 4,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("grades", 1);
    }

    public function testGradeCannotBeCreatedWithInvalidData(): void
    {
        $this->assertDatabaseCount("grades", 0);

        $this->post("/dashboard/semester-courses/{$this->gradeColumn->group->course_semester_id}/groups/{$this->gradeColumn->group->id}/grades/{$this->gradeColumn->id}/store", [
            "student_id" => "123",
            "status" => true,
        ])->assertSessionHasErrors()
            ->assertInvalid("student_id");

        $this->assertDatabaseCount("grades", 0);
    }

    public function testGradeCanBeUpdated(): void
    {
        $grade = Grade::factory()->create([
            "value" => 5,
            "status" => true,
        ]);
        $this->assertDatabaseHas("grades", [
            "value" => 5,
            "status" => true,
        ]);

        $this->patch("/dashboard/semester-courses/{$grade->gradeColumn->group->course_semester_id}/groups/{$grade->gradeColumn->group->id}/grades/{$grade->gradeColumn->id}/update", [
            "student_id" => $grade->student_id,
            "status" => true,
            "value" => 3,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("grades", [
            "value" => 3,
            "status" => true,
        ]);
    }
}
