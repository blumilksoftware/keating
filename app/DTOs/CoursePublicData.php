<?php

declare(strict_types=1);

namespace Keating\DTOs;

use Illuminate\Support\Collection;
use Keating\Enums\ClassType;
use Keating\Enums\SemesterName;
use Keating\Models\Course;

readonly class CoursePublicData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $abbreviation,
        public string $slug,
        public string $description,
        public string $semester,
        public string $semesterName,
        public string $type,
        public string $typeAbbreviation,
        public string $field,
        public string $fieldAbbreviation,
        public bool $active,
    ) {}

    public static function fromModel(Course $course, ?Collection $activeSemesters = null): self
    {
        return new self(
            id: $course->id,
            name: $course->name,
            abbreviation: $course->abbreviation,
            slug: $course->slug,
            description: $course->description,
            semester: $course->getRomanizedSemester(),
            semesterName: SemesterName::labels()[$course->semester_name],
            type: ClassType::labels()[$course->type],
            typeAbbreviation: ClassType::abbreviationLabels()[$course->type],
            field: $course->field->name,
            fieldAbbreviation: $course->field->abbreviation,
            active: $activeSemesters && ($activeSemesters->contains($course->getRomanizedSemester()) || $activeSemesters->contains($course->semester)),
        );
    }
}
