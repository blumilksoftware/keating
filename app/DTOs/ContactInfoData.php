<?php

declare(strict_types=1);

namespace Keating\DTOs;

use Keating\Models\ContactInfo;

readonly class ContactInfoData
{
    public function __construct(
        public string $label,
        public string $identifier,
    ) {}

    public static function fromModel(ContactInfo $contactInfo): self
    {
        return new self(
            label: $contactInfo->label,
            identifier: $contactInfo->identifier,
        );
    }
}
