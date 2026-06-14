<?php

namespace Illuminate\Notifications\Client\Response;

class SmsTrafficStatusResponse
{
    public function __construct(
        protected ?string $smsId = null,
        protected ?string $status = null,
        protected ?string $error = null,
        protected ?string $submissionDate = null,
        protected ?string $sendDate = null,
        protected ?string $lastStatusChangeDate = null,
    ) {
    }

    public static function fromXml(\SimpleXMLElement $data): self
    {
        $error = trim((string) ($data->error ?? ''));

        return new self(
            smsId: self::stringOrNull($data->sms_id ?? null),
            status: self::stringOrNull($data->status ?? null),
            error: $error !== '' ? $error : null,
            submissionDate: self::stringOrNull($data->submition_date ?? null),
            sendDate: self::stringOrNull($data->send_date ?? null),
            lastStatusChangeDate: self::stringOrNull($data->last_status_change_date ?? null),
        );
    }

    public function getSmsId(): ?string
    {
        return $this->smsId;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getSubmissionDate(): ?string
    {
        return $this->submissionDate;
    }

    public function getSendDate(): ?string
    {
        return $this->sendDate;
    }

    public function getLastStatusChangeDate(): ?string
    {
        return $this->lastStatusChangeDate;
    }

    public function hasError(): bool
    {
        return $this->error !== null && $this->error !== '';
    }

    protected static function stringOrNull(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $string = trim((string) $value);

        return $string !== '' ? $string : null;
    }
}
