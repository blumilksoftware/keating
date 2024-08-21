<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseSemesterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "course" => ["required", "exists:courses,id"],
            "semester" => ["required", "exists:semesters,id"],
        ];
    }

    public function getData(): array
    {
        return [
            "course_id" => $this->get("course"),
            "semester_id" => $this->get("semester"),
        ];
    }
}
