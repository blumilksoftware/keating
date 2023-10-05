<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\StudyForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CourseSemesterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "max:255"],
            "course_id" => ["required", "exists:courses,id"],
            "semester_id" => ["required", "exists:semesters,id"],
            "form" => ["required", new Enum(StudyForm::class)],
        ];
    }
}
