<?php

namespace NoviasNet\Yousign\DataObjects;

readonly class EmailNotification
{
    public function __construct(
        public ?EmailSender $sender = null,
        public ?string $customNote = null,
        public ?EmailCustomText $customText = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'sender' => $this->sender?->toArray(),
            'custom_note' => $this->customNote,
            'custom_text' => $this->customText?->toArray(),
        ], fn ($value) => $value !== null);
    }
}
