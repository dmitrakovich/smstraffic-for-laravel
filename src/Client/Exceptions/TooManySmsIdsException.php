<?php

namespace Illuminate\Notifications\Client\Exceptions;

class TooManySmsIdsException extends \InvalidArgumentException
{
    public const MAX_SMS_IDS = 15;

    public function __construct(int $count)
    {
        parent::__construct(sprintf(
            'Status request must not contain more than %d sms_id values, %d given.',
            self::MAX_SMS_IDS,
            $count,
        ));
    }
}
