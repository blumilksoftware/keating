<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory([
            "email" => "test@example.com",
            "password" => Hash::make("password"),
        ])->create();
    }

    public function testStudentCanBeCreated(): void
    {
        $this->assertDatabaseCount("students", 0);

        $this
            ->actingAs($this->user)
            ->post("/dashboard/students", [
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

        $this
            ->actingAs($this->user)
            ->patch("/dashboard/students/{$student->id}", [
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

        $this
            ->actingAs($this->user)
            ->post("/dashboard/students", [
                "name" => "Name",
                "surname" => "Surname",
                "index_number" => "12345",
            ])->assertSessionHasErrors("index_number");

        $this->assertDatabaseCount("students", 1);
    }

    public function testStudentCannotBeCreatedWithInvalidData(): void
    {
        $this
            ->actingAs($this->user)
            ->post("/dashboard/students", [
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

        $this
            ->actingAs($this->user)
            ->delete("/dashboard/students/{$student->id}");

        $this->assertDatabaseCount("students", 0);
    }
}
