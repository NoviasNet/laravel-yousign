<?php

namespace NoviasNet\Yousign\DataObjects;

use NoviasNet\Yousign\Enums\EmailSenderType;

readonly class EmailSender
{
    public function __construct(
        public EmailSenderType $type,
        public ?string $customName = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type->value,
            'custom_name' => $this->customName,
        ], fn ($value) => $value !== null);
    }
}
