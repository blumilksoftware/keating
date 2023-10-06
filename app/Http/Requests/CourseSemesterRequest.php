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
            "course" => ["required", "exists:courses,id"],
            "semester" => ["required", "exists:semesters,id"],
            "form" => ["required", new Enum(StudyForm::class)],
        ];
    }

    public function getData(): array
    {
        return [
            "course_id" => $this->get("course"),
            "semester_id" => $this->get("semester"),
            "form" => $this->get("form"),
        ];
    }
}
