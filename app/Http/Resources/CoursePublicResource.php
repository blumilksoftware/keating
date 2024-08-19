<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\ClassType;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

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
            "name" => $course->name,
            "abbreviation" => $course->abbreviation,
            "description" => $course->description,
            "semester" => $course->getRomanizedSemester(),
            "type" => ClassType::labels()[$course->type],
            "active" => $this->activeSemesters->contains($course->getRomanizedSemester()),
        ];
    }
}
