<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "max:255"],
            "surname" => ["required", "max:255"],
            "index_number" => ["required", "max:255", "unique:students,index_number"],
        ];
    }
}
