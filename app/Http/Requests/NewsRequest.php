<?php

declare(strict_types=1);

namespace App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "max:255"],
            "content" => ["required", "max:65000"],
        ];
    }

    public function getData(): array
    {
        return [
            "title" => $this->input("title"),
            "content" => $this->input("content"),
            "slug" => Str::slug($this->input("title")),
            "published_at" => Carbon::now()
        ];
    }


}
