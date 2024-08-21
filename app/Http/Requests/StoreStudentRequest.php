<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "first_name" => ["required", "max:255"],
            "surname" => ["required", "max:255"],
            "index_number" => ["required", "max:255", "unique:students,index_number"],
        ];
    }
}
