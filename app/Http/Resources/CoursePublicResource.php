<?php

declare(strict_types=1);

namespace Keating\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Keating\Enums\ClassType;
use Keating\Enums\SemesterName;
use Keating\Models\Course;

class CoursePublicResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(
        $resource,
        private Collection $activeSemesters,
    ) {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        /** @var Course $course */
        $course = $this;

        return [
            "id" => $course->id,
            "name" => $course->name,
            "abbreviation" => $course->abbreviation,
            "slug" => $course->slug,
            "description" => $course->description,
            "semester" => $course->getRomanizedSemester(),
            "semesterName" => SemesterName::labels()[$course->semester_name],
            "type" => ClassType::labels()[$course->type],
            "typeAbbreviation" => ClassType::abbreviationLabels()[$course->type],
            "field" => $course->field->name,
            "fieldAbbreviation" => $course->field->abbreviation,
            "active" => $this->activeSemesters->contains($course->getRomanizedSemester()) || $this->activeSemesters->contains($course->semester),
        ];
    }
}