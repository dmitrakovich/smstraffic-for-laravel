<?php

namespace Illuminate\Notifications\Client\Response;

class SmsTrafficStatusCollectionResponse extends SmsTrafficResponse
{
    /**
     * @param  list<SmsTrafficStatusResponse>  $statuses
     */
    public function __construct(
        protected array $statuses,
        \SimpleXMLElement $data,
    ) {
        parent::__construct($data);
    }

    /**
     * @return list<SmsTrafficStatusResponse>
     */
    public function getStatuses(): array
    {
        return $this->statuses;
    }

    public function hasError(): bool
    {
        return false;
    }
}
