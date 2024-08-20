<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "max:255"],
            "slug" => ["nullable", "max:255", Rule::unique("news", "slug")->ignore($this->route("news"))],
            "content" => ["required", "max:65000"],
        ];
    }

    public function getData(): array
    {
        return [
            "title" => $this->input("title"),
            "content" => $this->input("content"),
            "slug" => $this->slug,
            "published_at" => Carbon::now(),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            "slug" => $this->input("slug") !== null ? Str::slug($this->input("slug")) : Str::slug($this->input("title")),
        ]);
    }
}
