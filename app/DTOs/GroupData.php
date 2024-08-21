<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\StudyForm;
use App\Models\Group;

readonly class GroupData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $formAbbreviation,
        public string $form,
    ) {}

    public static function fromModel(Group $group): self
    {
        return new self(
            id: $group->id,
            name: $group->name,
            formAbbreviation: StudyForm::abbreviationLabels()[$group->form->value],
            form: $group->form->value,
        );
    }
}
