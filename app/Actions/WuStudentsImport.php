<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Student;

class WuStudentsImport
{
    protected array $students = [];

    public function import(string $content): array
    {
        $previousLine = null;

        foreach (explode("\n", $content) as $line) {
            if (str_starts_with($line, "nr albumu:")) {
                $names = explode(" ", $previousLine);

                $this->students[] = new Student([
                    "first_name" => $names[1] ?? "",
                    "surname" => $names[0] ?? "",
                    "index_number" => str_replace("nr albumu:", "", $line),
                ]);
            }

            $previousLine = $line;
        }

        return $this->students;
    }

    public function save(): void
    {
        /** @var Student $student */
        foreach ($this->students as $student) {
            if (Student::query()->where("index_number", $student->index_number)->count() === 0) {
                $student->save();
            }
        }
    }
}
