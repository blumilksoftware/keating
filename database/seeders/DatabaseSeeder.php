<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Keating\Models\CourseSemester;
use Keating\Models\Grade;
use Keating\Models\GradeColumn;
use Keating\Models\Group;
use Keating\Models\Section;
use Keating\Models\SectionSettings;
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
        $this->seedGrades();
    }

    protected function seedGrades(): void
    {
        $courses = CourseSemester::factory(5)->create();
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
