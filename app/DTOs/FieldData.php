<?php

declare(strict_types=1);

namespace Keating\DTOs;

use Keating\Models\Field;

readonly class FieldData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $abbreviation,
    ) {}

    public static function fromModel(Field $field): self
    {
        return new self(
            id: $field->id,
            name: $field->name,
            abbreviation: $field->abbreviation,
        );
    }
}
