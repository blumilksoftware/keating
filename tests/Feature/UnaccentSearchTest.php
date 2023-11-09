<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class UnaccentSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Student::factory()->create(["surname" => "Żłów"]);
        $this->actingAs($this->user);
        DB::statement("CREATE EXTENSION IF NOT EXISTS unaccent");
    }

    public function testStudentsCanBeSearchedWithoutAccentSensitivity(): void
    {
        $this->get("/dashboard/students?search=zlow")
            ->assertOk()
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Dashboard/Student/Index")
                    ->has("students.data", 1),
            );

        $this->get("/dashboard/students?search=abc")
            ->assertOk()
            ->assertInertia(
                fn(Assert $page): Assert => $page
                    ->component("Dashboard/Student/Index")
                    ->has("students.data", 0),
            );
    }
}
