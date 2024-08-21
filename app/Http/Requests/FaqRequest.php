<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "question" => ["required", "max:255"],
            "answer" => ["required", "max:65000"],
        ];
    }
}
