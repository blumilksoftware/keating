<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Keating\Actions\WuStudentsImport;
use Keating\Models\Student;
use Tests\TestCase;

class StudentImportTest extends TestCase
{
    use RefreshDatabase;

    public function testStudentsImport(): void
    {
        $content = file_get_contents(resource_path("tests/wu/protocol001.txt"));

        $importer = new WuStudentsImport();

        $students = $importer->import($content);
        $this->assertCount(36, $students);

        $importer->save();
        $this->assertDatabaseCount(Student::class, 36);
    }

    public function testRepeatedStudentsImport(): void
    {
        $data = [
            ["first_name" => "Sirius", "surname" => "Black", "index_number" => "83507"],
            ["first_name" => "Susan", "surname" => "Bones", "index_number" => "83608"],
            ["first_name" => "Tom", "surname" => "Riddle", "index_number" => "85999"],
        ];

        Student::factory()->count(count($data))->sequence(...$data)->create();

        $content = file_get_contents(resource_path("tests/wu/protocol001.txt"));

        $importer = new WuStudentsImport();

        $students = $importer->import($content);
        $this->assertCount(36, $students);

        $importer->save();
        $this->assertDatabaseCount(Student::class, 36);
    }

    public function testNewStudentsImport(): void
    {
        $data = [
            ["first_name" => "McGonagall", "surname" => "McGonagall", "index_number" => "89201"],
        ];

        Student::factory()->count(count($data))->sequence(...$data)->create();

        $content = file_get_contents(resource_path("tests/wu/protocol001.txt"));

        $importer = new WuStudentsImport();

        $students = $importer->import($content);
        $this->assertCount(36, $students);

        $importer->save();
        $this->assertDatabaseCount(Student::class, 37);
    }
}
