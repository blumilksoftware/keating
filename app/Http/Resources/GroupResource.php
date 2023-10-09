<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\StudyForm;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Group $group */
        $group = $this;

        return [
            "id" => $group->id,
            "name" => $group->name,
            "formAbbreviation" => StudyForm::abbreviationLabels()[$group->form->value],
            "form" => $group->form->value,
        ];
    }
}
