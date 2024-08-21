<?php

declare(strict_types=1);

namespace Keating\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Keating\Models\Field;

class FieldResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        /** @var Field $field */
        $field = $this;

        return [
            "id" => $field->id,
            "name" => $field->name,
            "abbreviation" => $field->abbreviation,
        ];
    }
}
