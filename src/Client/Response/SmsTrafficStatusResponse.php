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
        protected ?string $channel = null,
        protected ?string $deliveryDate = null,
        protected ?string $readDate = null,
        protected ?int $partsCount = null,
        protected ?int $partsDeliveredCount = null,
        protected ?string $channelStatus = null,
    ) {
    }

    public static function fromXml(\SimpleXMLElement $data): self
    {
        if (isset($data->id) || isset($data->{'channel-info'})) {
            return self::fromSmartDeliveryXml($data);
        }

        return self::fromClassicXml($data);
    }

    /**
     * @return list<string>
     */
    public static function finalStatuses(): array
    {
        return [
            // Classic RU API
            'Delivered',
            'Non Delivered',
            'Rejected',
            'Expired',
            'Deleted',
            'Unknown status',
            // Smart Delivery BY
            'READ',
            'DELIVERED',
            'EXPIRED',
            'REJECTED',
            'DELETED',
            'FAILED',
            'UNDELIVERED',
        ];
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

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    public function getReadDate(): ?string
    {
        return $this->readDate;
    }

    public function getChannelStatus(): ?string
    {
        return $this->channelStatus;
    }

    public function getPartsCount(): ?int
    {
        return $this->partsCount;
    }

    public function getPartsDeliveredCount(): ?int
    {
        return $this->partsDeliveredCount;
    }

    public function hasError(): bool
    {
        return $this->error !== null && $this->error !== '';
    }

    public function isFinal(): bool
    {
        $status = $this->getStatus();

        if ($status === null) {
            return false;
        }

        foreach (self::finalStatuses() as $finalStatus) {
            if (strcasecmp($status, $finalStatus) === 0) {
                return true;
            }
        }

        return false;
    }

    protected static function fromClassicXml(\SimpleXMLElement $data): self
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

    protected static function fromSmartDeliveryXml(\SimpleXMLElement $data): self
    {
        $channelInfo = $data->{'channel-info'} ?? null;
        $error = trim((string) ($data->error ?? ''));

        return new self(
            smsId: self::stringOrNull($data->id ?? $data->sms_id ?? null),
            status: self::stringOrNull($data->status ?? null),
            error: $error !== '' ? $error : null,
            submissionDate: self::stringOrNull($data->submition_date ?? null),
            sendDate: self::stringOrNull($channelInfo?->sent_date ?? $data->send_date ?? null),
            lastStatusChangeDate: self::stringOrNull(
                $data->last_update_status ?? $data->last_status_change_date ?? null,
            ),
            channel: self::stringOrNull($channelInfo?->channel ?? null),
            deliveryDate: self::stringOrNull($channelInfo?->delivery_date ?? null),
            readDate: self::stringOrNull($channelInfo?->read_date ?? null),
            partsCount: self::intOrNull($channelInfo?->parts_count ?? null),
            partsDeliveredCount: self::intOrNull($channelInfo?->parts_dlv_count ?? null),
            channelStatus: self::stringOrNull($channelInfo?->status ?? null),
        );
    }

    protected static function stringOrNull(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $string = trim((string) $value);

        return $string !== '' ? $string : null;
    }

    protected static function intOrNull(mixed $value): ?int
    {
        $string = self::stringOrNull($value);

        if ($string === null) {
            return null;
        }

        return (int) $string;
    }
}
