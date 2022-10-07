<?php

namespace Illuminate\Notifications\Client;

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
    protected const DEFAULT_OPTIONS = [
        'want_sms_ids' => 1,
    ];

    /**
     * Create a new SmsTraffic instance.
     */
    public function __construct(
        protected string $login,
        protected string $password,
        protected string $from = null,
        protected string $logChannel = null,
    ) {
    }

    // log
    // set log template (with manager inside)

    /**
     * Test
     */
    public function send(string $message, string $to, array $options = [])
    {
        $payload = [
            'originator' => $this->from,
            'phones' => $to, // !!! check foramts
            'message' => $message,
        ];
        foreach (self::DEFAULT_OPTIONS as $name => $value) {
            $payload[$name] = $value;
        }
        foreach ($options as $name => $value) {
            if (array_key_exists($name, self::KNOWN_OPTIONS) || str_starts_with('', 'param_')) {
                $payload[$name] = $value;
            }
        }

        $response = $this->request($payload);

        return $response;
    }

    /**
     * Test
     */
    protected function request(array $payload)
    {
        $client = new \GuzzleHttp\Client();

        $params = [
            'form_params' => array_merge([
                'login' => $this->login,
                'password' => $this->password,
            ], $payload),
        ];

        return $client->post(self::MAIN_URL, $params);
    }
}
