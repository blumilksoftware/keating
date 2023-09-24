<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "email", "max:255"],
            "github_handle" => ["nullable", "url"],
            "alternative_channel" => ["nullable", "url"],
        ];
    }
}
