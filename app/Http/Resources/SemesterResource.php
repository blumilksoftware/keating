<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Semester $semester */
        $semester = $this;

        return [
            "id" => $semester->id,
            "name" => $semester->name,
            "status" => $semester->status,
            "statusLabel" => $semester->status->getLabel(),
        ];
    }
}
