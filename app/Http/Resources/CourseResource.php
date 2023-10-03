<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\ClassType;
use App\Enums\StudyForm;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "form" => StudyForm::labels()[$course->form],
        ];
    }
}
