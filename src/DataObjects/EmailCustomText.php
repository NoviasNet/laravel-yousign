<?php

namespace NoviasNet\Yousign\DataObjects;

readonly class EmailCustomText
{
    public function __construct(
        public ?string $requestSubject = null,
        public ?string $requestBody = null,
        public ?string $reminderSubject = null,
        public ?string $reminderBody = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'request_subject' => $this->requestSubject,
            'request_body' => $this->requestBody,
            'reminder_subject' => $this->reminderSubject,
            'reminder_body' => $this->reminderBody,
        ], fn ($value) => $value !== null);
    }
}
