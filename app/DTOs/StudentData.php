<?php

declare(strict_types=1);

namespace Keating\DTOs;

use Illuminate\Support\Collection;
use Keating\Models\Grade;
use Keating\Models\GradeColumn;
use Keating\Models\Student;

readonly class StudentData
{
    public function __construct(
        public string $student,
        public Collection $grades,
    ) {}

    public static function fromModels(Student $student, Student $studentByIndex, Collection $gradeColumns): self
    {
        return new self(
            student: $student->id === $studentByIndex->id ? $student->index_number : "",
            grades: self::prepareGrades($student, $gradeColumns),
        );
    }

    public static function prepareGrades(Student $student, Collection $gradeColumns): Collection
    {
        return $gradeColumns->map(function (GradeColumn $column) use ($student): array {
            /** @var Grade $grade */
            $grade = Grade::query()
                ->where("grade_column_id", $column->id)
                ->where("student_id", $student->id)
                ->first();

            return $grade
                ? [
                    "present" => $grade->status,
                    "value" => $grade->value,
                ]
                : [
                    "present" => null,
                    "value" => null,
                ];
        });
    }
}
