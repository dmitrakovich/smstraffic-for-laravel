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
        $classic = (string) ($this->data->message_infos?->message_info?->sms_id ?? '');

        if ($classic !== '') {
            return $classic;
        }

        $smartFromMessageInfos = (string) ($this->data->message_infos?->message_info?->id ?? '');

        if ($smartFromMessageInfos !== '') {
            return $smartFromMessageInfos;
        }

        $smart = (string) ($this->data->{'msg-info'}?->id ?? '');

        return $smart !== '' ? $smart : null;
    }
}
