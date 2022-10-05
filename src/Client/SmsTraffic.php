<?php

namespace Illuminate\Notifications\Client;

class SmsTraffic
{
    /**
     * Create a new SmsTraffic instance.
     */
    public function __construct(protected string $login, protected string $password)
    {
    }


    /**
     * Test
     */
    public function send()
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->post('http://example.co.uk/auth/token', [
            'form_params' => [
                'login' => $this->login,
                'password' => $this->password,
                'phones' => '375333467338',
                'message' => 'HI, it\'s  second test message (00:20)',
            ]
        ]);

        return $response;
    }
}
