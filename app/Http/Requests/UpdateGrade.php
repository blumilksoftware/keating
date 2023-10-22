<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrade extends FormRequest
{
    public function rules(): array
    {
        return [
            "student_id" => ["required", "exists:students,id"],
        ];
    }

    public function getData(): array
    {
        return [
            "student_id" => $this->get("student_id"),
            "status" => $this->boolean("status"),
            "value" => $this->get("value"),
        ];
    }
}
