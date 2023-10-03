<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "max:255"],
            "abbreviation" => ["required", "max:255"],
            "description" => ["nullable", "max:65000"],
            "semester" => ["required", "max:255"],
        ];
    }
}
