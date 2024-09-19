<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeColumnRequest extends FormRequest
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
