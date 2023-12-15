<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CourseSemester;
use App\Models\Grade;
use App\Models\GradeColumn;
use App\Models\Group;
use App\Models\Section;
use App\Models\SectionSettings;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

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
