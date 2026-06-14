<?php

namespace Illuminate\Notifications\Tests;

use Illuminate\Notifications\Client\Exceptions\TooManySmsIdsException;
use Illuminate\Notifications\Client\SmsTraffic;
use PHPUnit\Framework\TestCase;

class SmsTrafficStatusTest extends TestCase
{
    protected function makeClient(): SmsTraffic
    {
        return new SmsTraffic('login', 'password', 'https://example.test/multi.php', 'https://backup.test/multi.php');
    }

    public function test_status_with_more_than_fifteen_ids_throws_exception(): void
    {
        $client = $this->makeClient();

        $smsIds = array_map(static fn (int $index): string => (string) $index, range(1, 16));

        $this->expectException(TooManySmsIdsException::class);

        $client->status($smsIds);
    }

    public function test_status_with_empty_ids_throws_exception(): void
    {
        $client = $this->makeClient();

        $this->expectException(\InvalidArgumentException::class);

        $client->status([]);
    }
}
