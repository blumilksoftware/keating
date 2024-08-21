<?php

declare(strict_types=1);

namespace Keating\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Keating\Enums\StudyForm;
use Keating\Models\Group;

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
