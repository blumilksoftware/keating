<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\GradeColumn;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class GradeColumnTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->group = Group::factory()->create();
        $this->actingAs($this->user);
    }

    public function testGradeColumnCanBeCreated(): void
    {
        $this->assertDatabaseCount("grade_columns", 0);

        $this->post("/dashboard/semester-courses/{$this->group->course_semester_id}/groups/{$this->group->id}/grades", [
            "name" => "LAB01",
            "active" => true,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("grade_columns", 1);
    }

    public function testGradeColumnCanBeUpdated(): void
    {
        $gradeColumn = GradeColumn::factory()->create([
            "name" => "LAB000",
            "active" => false,
        ]);
        $this->assertDatabaseHas("grade_columns", [
            "name" => "LAB000",
            "active" => false,
        ]);

        $this->patch("/dashboard/semester-courses/{$gradeColumn->group->course_semester_id}/groups/{$gradeColumn->group->id}/grades/{$gradeColumn->id}", [
            "name" => "LAB01",
            "active" => true,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("grade_columns", [
            "name" => "LAB01",
            "active" => true,
        ]);
    }

    public function testGradeColumnCanBeDeleted(): void
    {
        $gradeColumn = GradeColumn::factory()->create();
        $this->assertDatabaseCount("grade_columns", 1);

        $this->delete("/dashboard/semester-courses/{$gradeColumn->group->course_semester_id}/groups/{$gradeColumn->group->id}/grades/{$gradeColumn->id}")
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount("grade_columns", 0);
    }

    public function testGradeColumnCanBeReordered(): void
    {
        $gradeColumnOne = GradeColumn::factory()->create(["priority" => 1]);
        $gradeColumnTwo = GradeColumn::factory()->create(["priority" => 2, "group_id" => $gradeColumnOne->group->id]);
        $this->assertSame(1, $gradeColumnOne->priority);
        $this->assertSame(2, $gradeColumnTwo->priority);

        $this->post("/dashboard/semester-courses/{$gradeColumnOne->group->course_semester_id}/groups/{$gradeColumnOne->group->id}/grades/{$gradeColumnOne->id}/reorder/0")
            ->assertSessionHasNoErrors();

        $gradeColumnOne->refresh();
        $gradeColumnTwo->refresh();
        $this->assertSame(2, $gradeColumnOne->priority);
        $this->assertSame(1, $gradeColumnTwo->priority);
    }

    public function testGradeColumnCannotBeCreatedWithInvalidData(): void
    {
        $this->assertDatabaseCount("grade_columns", 0);

        $this->post("/dashboard/semester-courses/{$this->group->course_semester_id}/groups/{$this->group->id}/grades", [
            "name" => Str::random(31),
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "name",
            ]);

        $this->assertDatabaseCount("grade_columns", 0);
    }

    public function testGradeColumnCannotBeUpdatedWithInvalidData(): void
    {
        $gradeColumn = GradeColumn::factory()->create([
            "name" => "LAB000",
            "active" => false,
        ]);

        $this->patch("/dashboard/semester-courses/{$gradeColumn->group->course_semester_id}/groups/{$gradeColumn->group->id}/grades/{$gradeColumn->id}", [
            "name" => Str::random(31),
        ])->assertSessionHasErrors()
            ->assertInvalid([
                "name",
            ]);
    }
}
