<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Keating\Enums\Icons;

class ContactInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "label" => ["required", "string", "max:255"],
            "identifier" => ["required", "string", "max:255"],
            "icon" => ["required", new Enum(Icons::class)],
        ];
    }
}
