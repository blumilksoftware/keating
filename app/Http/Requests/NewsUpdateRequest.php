<?php

declare(strict_types=1);

namespace Keating\Http\Requests;

class NewsUpdateRequest extends NewsRequest
{
    public function getData(): array
    {
        return [
            "title" => $this->input("title"),
            "content" => $this->input("content"),
            "slug" => $this->slug,
        ];
    }
}
