<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Models\CourseSemester;

readonly class CourseSemesterData
{
    public function __construct(
        public string $id,
        public string $course,
        public string $semester,
        public string $semesterId,
        public int $groupsCount,
    ) {}

    public static function fromModel(CourseSemester $course): self
    {
        return new self(
            id: $course->id,
            course: $course->course->name,
            semester: $course->semester->name,
            semesterId: $course->semester->id,
            groupsCount: $course->groups_count ?? $course->groups->count(),
        );
    }
}
