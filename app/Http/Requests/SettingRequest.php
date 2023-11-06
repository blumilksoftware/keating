<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "teacher_name" => ["nullable", "max:255"],
            "teacher_email" => ["nullable", "email", "max:255"],
            "teacher_titles" => ["nullable", "max:255"],
            "university_name" => ["nullable", "max:255"],
            "department_name" => ["nullable", "max:255"],
        ];
    }
}
