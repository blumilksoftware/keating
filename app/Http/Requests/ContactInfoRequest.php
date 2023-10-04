<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Icons;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
