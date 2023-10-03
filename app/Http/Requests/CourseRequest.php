<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ClassType;
use App\Enums\StudyForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "max:255"],
            "abbreviation" => ["required", "max:255"],
            "description" => ["nullable", "max:65000"],
            "semester" => ["required", "numeric", "min:1", "max:10"],
            "type" => ["required", new Enum(ClassType::class)],
            "form" => ["required", new Enum(StudyForm::class)],
        ];
    }
}
