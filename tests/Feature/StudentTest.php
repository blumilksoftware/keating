<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function testStudentCanBeCreated(): void
    {
        $this->assertDatabaseCount("students", 0);

        $this->post("/dashboard/students", [
            "name" => "Name",
            "surname" => "Surname",
            "index_number" => "12345",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("students", 1);
    }

    public function testStudentCanBeUpdated(): void
    {
        $student = Student::factory()->create();

        $this->assertDatabaseMissing("students", [
            "name" => "Name",
            "surname" => "Surname",
            "index_number" => "12345",
        ]);

        $this->patch("/dashboard/students/{$student->id}", [
            "name" => "Name",
            "surname" => "Surname",
            "index_number" => "12345",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("students", [
            "name" => "Name",
            "surname" => "Surname",
            "index_number" => "12345",
        ]);
    }

    public function testStudentCannotBeCreatedWithBusyIndex(): void
    {
        Student::factory()->create(["index_number" => "12345"]);
        $this->assertDatabaseCount("students", 1);

        $this->post("/dashboard/students", [
            "name" => "Name",
            "surname" => "Surname",
            "index_number" => "12345",
        ])->assertSessionHasErrors("index_number");

        $this->assertDatabaseCount("students", 1);
    }

    public function testStudentCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/students", [
            "name" => Str::random(256),
            "surname" => Str::random(256),
            "index_number" => Str::random(256),
        ])->assertSessionHasErrors([
            "name",
            "surname",
            "index_number",
        ]);

        $this->assertDatabaseCount("students", 0);
    }

    public function testStudentCanBeDeleted(): void
    {
        $student = Student::factory()->create();
        $this->assertDatabaseCount("students", 1);

        $this->delete("/dashboard/students/{$student->id}");

        $this->assertDatabaseCount("students", 0);
    }
}
