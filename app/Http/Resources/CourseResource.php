<?php

declare(strict_types=1);

namespace Keating\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Keating\Enums\ClassType;
use Keating\Models\Course;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Course $course */
        $course = $this;

        return [
            "id" => $course->id,
            "name" => $course->name,
            "abbreviation" => $course->abbreviation,
            "description" => $course->description,
            "semester" => $course->getRomanizedSemester(),
            "type" => ClassType::labels()[$course->type],
        ];
    }
}
