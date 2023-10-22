<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeColumn extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "max:20"],
        ];
    }

    public function getData(): array
    {
        return [
            "name" => $this->get("name"),
            "active" => $this->boolean("active"),
        ];
    }
}
