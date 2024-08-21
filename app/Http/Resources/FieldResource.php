<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
