<?php

declare(strict_types=1);

namespace Keating\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Keating\Models\CourseSemester;

class CourseSemesterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var CourseSemester $course */
        $course = $this;

        return [
            "id" => $course->id,
            "course" => $course->course->name,
            "semester" => $course->semester->name,
            "semesterId" => $course->semester->id,
            "groupsCount" => $course->groups_count ?? $course->groups->count(),
        ];
    }
}
