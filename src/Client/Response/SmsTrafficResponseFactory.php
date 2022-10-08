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
            return self::createSuccessResponse(new \SimpleXMLElement($rawResponseData));
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
     * Create a new SmsTrafficErrorResponse instance.
     */
    public static function createErrorResponse(string $errorMessage): SmsTrafficErrorResponse
    {
        return new SmsTrafficErrorResponse((object)[
            'code' => SmsTrafficResponse::BAD_RESPONSE_ERROR_CODE,
            'description' => $errorMessage,
            'result' => SmsTrafficResponse::RESULT_ERROR,
        ]);
    }
}
