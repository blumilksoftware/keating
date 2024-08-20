<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "max:255"],
            "abbreviation" => ["required", "max:255"],
        ];
    }
}
