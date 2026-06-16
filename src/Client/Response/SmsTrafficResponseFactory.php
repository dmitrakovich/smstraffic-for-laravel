<?php

namespace Illuminate\Notifications\Client\Response;

class SmsTrafficResponseFactory
{
    /**
     * Create a new SmsTrafficResponse instance.
     */
    public static function createResponse(string $rawResponseData): SmsTrafficResponse
    {
        try {
            $data = new \SimpleXMLElement($rawResponseData);

            if (self::isApiErrorResponse($data)) {
                return new SmsTrafficErrorResponse($data);
            }

            if (self::isStatusResponse($data)) {
                return self::createStatusCollectionResponse($data);
            }

            return self::createSuccessResponse($data);
        } catch (\Throwable $th) {
            return self::createErrorResponse($th->getMessage());
        }
    }

    /**
     * Create a new SmsTrafficSuccessResponse instance.
     */
    public static function createSuccessResponse(\SimpleXMLElement $data): SmsTrafficSuccessResponse
    {
        return new SmsTrafficSuccessResponse($data);
    }

    /**
     * Create a new SmsTrafficStatusCollectionResponse instance.
     */
    public static function createStatusCollectionResponse(\SimpleXMLElement $data): SmsTrafficStatusCollectionResponse
    {
        $statuses = [];

        if (isset($data->sms)) {
            foreach ($data->sms as $sms) {
                $statuses[] = SmsTrafficStatusResponse::fromXml($sms);
            }
        } elseif (isset($data->{'msg-infos'})) {
            foreach ($data->{'msg-infos'}->{'msg-info'} as $msgInfo) {
                $statuses[] = SmsTrafficStatusResponse::fromXml($msgInfo);
            }
        } elseif (isset($data->{'msg-info'})) {
            foreach ($data->{'msg-info'} as $msgInfo) {
                $statuses[] = SmsTrafficStatusResponse::fromXml($msgInfo);
            }
        } else {
            $statuses[] = SmsTrafficStatusResponse::fromXml($data);
        }

        return new SmsTrafficStatusCollectionResponse($statuses, $data);
    }

    /**
     * Create a new SmsTrafficErrorResponse instance.
     */
    public static function createErrorResponse(string $errorMessage): SmsTrafficErrorResponse
    {
        return new SmsTrafficErrorResponse((object) [
            'code' => SmsTrafficResponse::BAD_RESPONSE_ERROR_CODE,
            'description' => $errorMessage,
            'result' => SmsTrafficResponse::RESULT_ERROR,
        ]);
    }

    protected static function isApiErrorResponse(\SimpleXMLElement $data): bool
    {
        $result = (string) ($data->result ?? '');

        if ($result === SmsTrafficResponse::RESULT_ERROR) {
            return true;
        }

        $code = intval($data->code ?? 0);

        return $code > 0 && ! self::isStatusResponse($data);
    }

    protected static function isStatusResponse(\SimpleXMLElement $data): bool
    {
        if (isset($data->message_infos)) {
            return false;
        }

        if (isset($data->sms)) {
            return true;
        }

        if (isset($data->{'msg-info'}) || isset($data->{'msg-infos'})) {
            return true;
        }

        return isset($data->status) || isset($data->sms_id);
    }
}
