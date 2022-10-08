<?php

namespace Illuminate\Notifications\Client;

use Illuminate\Notifications\Client\Response\SmsTrafficResponse;
use Illuminate\Notifications\Client\Response\SmsTrafficResponseFactory;

class SmsTraffic
{
    /**
     *
     */
    protected const MAIN_URL = 'https://sds.smstraffic.ru/smartdelivery-in/multi.php';

    /**
     *
     */
    protected const BACKUP_URL = 'https://sds2.smstraffic.ru/smartdelivery-in/multi.php';

    /**
     *
     */
    protected const KNOWN_OPTIONS = [
        'originator' => '',
        'rus' => 0,
        'max_parts' => 255,
        'autotruncate' => 0,
        'individual_messages' => 0,
        'delimiter' => "\n",
        'want_sms_ids' => 0,
        'routeGroupId' => 0,
        'start_date' => '',
        'stop_date' => '',
        'isSendNextDay' => 0,
        'isAbonentLocaleTime' => 0,
        'route' => '',
        'image_url' => '',
        'btn_url' => '',
        'btn_name' => '',
        'batch_name' => '',
        'tracking_data' => '',
        'link_in_text' => 0,
        'template_id' => 0,
        'email' => '',
        'ignore_phone_format' => 0,
        'param_push_content' => '',
    ];

    /**
     *
     */
    protected array $defaultOptions = [
        'want_sms_ids' => 1,
    ];

    /**
     * Create a new SmsTraffic instance.
     */
    public function __construct(protected string $login, protected string $password)
    {
    }

    /**
     * Add default option value
     */
    public function setDefaultOption(string $name, string $value): void
    {
        if ($this->validateOption($name)) {
            $this->defaultOptions[$name] = $value;
        }
    }

    /**
     * Check is option name valid
     */
    protected function validateOption(string $name): bool
    {
        return array_key_exists($name, self::KNOWN_OPTIONS) || str_starts_with('', 'param_');
    }

    /**
     * Send sms to recipient
     */
    public function send(string $to, string $message, array $options = []): SmsTrafficResponse
    {
        $payload = [
            'phones' => $this->preparePhones($to),
            'message' => $message,
        ];
        foreach ($this->defaultOptions as $name => $value) {
            $payload[$name] = $value;
        }
        foreach ($options as $name => $value) {
            if ($this->validateOption($name)) {
                $payload[$name] = $value;
            }
        }

        return $this->request($payload);
    }

    /**
     * Prepare phone numbers for sms traffic
     */
    protected function preparePhones(string $phones): string
    {
        return preg_replace('/[^0-9,]/', '', $phones);
    }

    /**
     * Send request by SmsTraffic API.
     */
    protected function request(array $payload): SmsTrafficResponse
    {
        $client = new \GuzzleHttp\Client();

        $params = [
            'form_params' => array_merge([
                'login' => $this->login,
                'password' => $this->password,
            ], $payload),
        ];

        $response = $this->getResponse($client, $params);

        if ($response->hasError() && $response->isServerError()) {
            $response = $this->getResponse($client, $params, true);
        }

        return $response;
    }

    /**
     * Get response instance.
     */
    protected function getResponse(\GuzzleHttp\Client $client, array $params, bool $useBackupUrl = false): SmsTrafficResponse
    {
        $url = $useBackupUrl ? self::BACKUP_URL : self::MAIN_URL;

        try {
            $response = $client->post($url, $params);
            $rawContent = $response->getBody()->getContents();
            return SmsTrafficResponseFactory::createResponse($rawContent);
        } catch (\Throwable $th) {
            return SmsTrafficResponseFactory::createErrorResponse($th->getMessage());
        }
    }
}
