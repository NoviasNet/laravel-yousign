<?php

namespace NoviasNet\Yousign\DataObjects;

use NoviasNet\Yousign\Enums\AuditTrailLocale;
use NoviasNet\Yousign\Enums\DeliveryMode;

readonly class CreateSignatureRequest
{
    public function __construct(
        public string $name,
        public DeliveryMode $deliveryMode,

        public ?bool $orderedSigners = null,
        public ?bool $orderedApprovers = null,
        public ?bool $customRecipientOrder = null,
        public ?string $timezone = null,
        public ?string $expirationDate = null,
        public ?string $externalId = null,
        public ?AuditTrailLocale $auditTrailLocale = null,
        public ?bool $signersAllowedToDecline = null,
        public ?string $templateId = null,
        public ?string $customExperienceId = null,
        public ?string $workspaceId = null,
        public ?string $workflowSessionId = null,
        public ?string $previousAttemptId = null,

        public ?ReminderSettings $reminderSettings = null,
        public ?EmailNotification $emailNotification = null,
        public ?array $labels = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'delivery_mode' => $this->deliveryMode->value,
            'ordered_signers' => $this->orderedSigners,
            'ordered_approvers' => $this->orderedApprovers,
            'custom_recipient_order' => $this->customRecipientOrder,
            'timezone' => $this->timezone,
            'expiration_date' => $this->expirationDate,
            'external_id' => $this->externalId,
            'audit_trail_locale' => $this->auditTrailLocale?->value,
            'signers_allowed_to_decline' => $this->signersAllowedToDecline,
            'template_id' => $this->templateId,
            'custom_experience_id' => $this->customExperienceId,
            'workspace_id' => $this->workspaceId,
            'workflow_session_id' => $this->workflowSessionId,
            'previous_attempt_id' => $this->previousAttemptId,
            'reminder_settings' => $this->reminderSettings?->toArray(),
            'email_notification' => $this->emailNotification?->toArray(),
            'labels' => $this->labels,
        ], fn ($value) => $value !== null);
    }
}
