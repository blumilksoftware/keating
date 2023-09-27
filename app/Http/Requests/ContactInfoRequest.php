<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "label" => ["required", "string", "max:255"],
            "identifier" => ["required", "string", "max:255"],
        ];
    }
}
