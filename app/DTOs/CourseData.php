<?php

declare(strict_types=1);

namespace Keating\DTOs;

use Keating\Enums\ClassType;
use Keating\Models\Course;

readonly class CourseData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $abbreviation,
        public string $description,
        public string $semester,
        public string $type,
    ) {}

    public static function fromModel(Course $course): self
    {
        return new self(
            id: $course->id,
            name: $course->name,
            abbreviation: $course->abbreviation,
            description: $course->description,
            semester: $course->getRomanizedSemester(),
            type: ClassType::labels()[$course->type],
        );
    }
}
