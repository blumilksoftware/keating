<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Keating\Enums\SectionType;

class SectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "max:255"],
            "value" => ["required", "max:65000"],
            "type" => ["required", new Enum(SectionType::class)],
        ];
    }
}
