<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\StudyForm;
use App\Models\CourseSemester;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "form" => StudyForm::labels()[$course->form->value],
        ];
    }
}
