<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\SectionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
