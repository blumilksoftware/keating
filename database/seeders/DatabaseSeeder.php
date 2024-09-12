<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Keating\Enums\SemesterName;
use Keating\Models\Course;
use Keating\Models\CourseSemester;
use Keating\Models\Field;
use Keating\Models\Grade;
use Keating\Models\GradeColumn;
use Keating\Models\Group;
use Keating\Models\Section;
use Keating\Models\SectionSettings;
use Keating\Models\Semester;
use Keating\Models\Setting;
use Keating\Models\Student;
use Keating\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(["email" => "admin@example.com"]);

        Setting::factory()->create();
        Section::factory(4)->counter()->create();
        Section::factory(3)->about()->create();
        SectionSettings::query()->create([
            "banner_enabled" => true,
            "about_enabled" => true,
            "counters_enabled" => true,
            "contact_enabled" => true,
        ]);

        $this->seedRealData();
    }

    protected function seedRealData(): void
    {
        $semesters = Semester::factory()->count(5)->sequence(
            ["name" => "zimowy 2022/23", "active" => false],
            ["name" => "letni 2022/23", "active" => false],
            ["name" => "zimowy 2023/24", "active" => false],
            ["name" => "letni 2023/24", "active" => false],
            ["name" => "zimowy 2024/25", "active" => true],
        )->create();

        $fields = Field::factory()->count(3)->sequence(
            ["name" => "Informatyka", "abbreviation" => "INF"],
            ["name" => "Informatyka, specjalność Programowanie", "abbreviation" => "INF/PAM"],
            ["name" => "Informatyka, specjalność Grafika", "abbreviation" => "INF/GK"],
        )->create();

        $courses = Course::factory()->count(3)->sequence(
            [
                "name" => "Programowanie obiektowe",
                "abbreviation" => "PO",
                "semester" => 3,
                "type" => "laboratory",
                "field_id" => $fields[1]->id,
                "semester_name" => SemesterName::Winter->value,
            ],
            [
                "name" => "Programowanie systemów internetowych",
                "abbreviation" => "PSI",
                "semester" => 4,
                "type" => "lecture",
                "field_id" => $fields[2]->id,
                "semester_name" => SemesterName::Summer->value,
            ],
            [
                "name" => "Programowanie systemów internetowych",
                "abbreviation" => "PSI",
                "semester" => 4,
                "type" => "project",
                "field_id" => $fields[2]->id,
                "semester_name" => SemesterName::Summer->value,
            ],
        )->create();

        $courses = CourseSemester::factory(7)->sequence(
            ["course_id" => $courses[0]->id, "semester_id" => $semesters[4]->id],
            ["course_id" => $courses[1]->id, "semester_id" => $semesters[3]->id],
            ["course_id" => $courses[2]->id, "semester_id" => $semesters[3]->id],
            ["course_id" => $courses[0]->id, "semester_id" => $semesters[2]->id],
            ["course_id" => $courses[1]->id, "semester_id" => $semesters[1]->id],
            ["course_id" => $courses[2]->id, "semester_id" => $semesters[1]->id],
            ["course_id" => $courses[0]->id, "semester_id" => $semesters[0]->id],
        )->create();

        $students = Student::factory(100)->create();

        foreach ($courses as $course) {
            $groups = Group::factory(fake()->numberBetween(2, 6))->create([
                "course_semester_id" => $course->id,
            ]);

            /** @var Group $group */
            foreach ($groups as $group) {
                $group->students()->sync($students->random(15));
                $columns = GradeColumn::factory(15)->create([
                    "group_id" => $group->id,
                ]);

                foreach ($group->students as $student) {
                    foreach ($columns as $column) {
                        Grade::factory()->create([
                            "grade_column_id" => $column->id,
                            "student_id" => $student->id,
                        ]);
                    }
                }
            }
        }
    }
}
