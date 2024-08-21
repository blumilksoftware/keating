<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ClassType;
use App\Enums\SemesterName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            "field_id" => ["required", "exists:fields,id"],
            "semester_name" => ["required", new Enum(SemesterName::class)],
            "slug" => ["nullable", "max:255", Rule::unique("courses", "slug")->ignore($this->route("course"))],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            "slug" => $this->input("slug") !== null ? Str::slug($this->input("slug")) : Str::slug($this->input("name")),
        ]);
    }
}
