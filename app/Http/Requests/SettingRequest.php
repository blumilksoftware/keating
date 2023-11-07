<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "teacher_name" => ["required", "max:255"],
            "teacher_email" => ["required", "email", "max:255"],
            "teacher_titles" => ["required", "max:255"],
            "university_name" => ["required", "max:255"],
            "department_name" => ["required", "max:255"],
        ];
    }
}
