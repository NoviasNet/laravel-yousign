<?php

namespace NoviasNet\Yousign\DataObjects;

use NoviasNet\Yousign\Enums\ReminderIntervalInDays;

readonly class ReminderSettings
{
    public function __construct(
        public ReminderIntervalInDays $intervalInDays,
        public int $maxOccurrences,
    ) {}

    public function toArray(): array
    {
        return [
            'interval_in_days' => $this->intervalInDays->value,
            'max_occurrences' => $this->maxOccurrences,
        ];
    }
}
