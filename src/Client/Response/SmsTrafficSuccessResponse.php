<?php

namespace Illuminate\Notifications\Client\Response;

class SmsTrafficSuccessResponse extends SmsTrafficResponse
{
    /**
     * Create a new SmsTrafficSuccessResponse instance.
     */
    public function __construct(\SimpleXMLElement $data)
    {
        $this->data = $data;
    }

    /**
     * Get sms id from response
     */
    public function getSmsId(): ?string
    {
        return (string)$this->data->message_infos?->message_info?->sms_id ?: null;
    }
}
