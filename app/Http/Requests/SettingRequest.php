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
            "primary_color" => ["required", "regex:/^#([A-Fa-f0-9]{6})$/"],
            "secondary_color" => ["required", "regex:/^#([A-Fa-f0-9]{6})$/"],
            "logo" => ["nullable", "image", "max:1024"],
        ];
    }

    public function getData(): array
    {
        return [
            "teacher_name" => $this->input("teacher_name"),
            "teacher_email" => $this->input("teacher_email"),
            "teacher_titles" => $this->input("teacher_titles"),
            "university_name" => $this->input("university_name"),
            "department_name" => $this->input("department_name"),
            "primary_color" => $this->input("primary_color"),
            "secondary_color" => $this->input("secondary_color"),
        ];
    }
}
