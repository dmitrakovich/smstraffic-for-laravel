<?php

namespace Illuminate\Notifications\Tests;

use Illuminate\Notifications\Client\Exceptions\TooManySmsIdsException;
use Illuminate\Notifications\Client\Response\SmsTrafficErrorResponse;
use Illuminate\Notifications\Client\Response\SmsTrafficStatusCollectionResponse;
use Illuminate\Notifications\Client\Response\SmsTrafficSuccessResponse;
use Illuminate\Notifications\Client\Response\SmsTrafficResponseFactory;
use PHPUnit\Framework\TestCase;

class SmsTrafficResponseFactoryTest extends TestCase
{
    protected function fixture(string $name): string
    {
        return file_get_contents(__DIR__.'/fixtures/'.$name);
    }

    public function test_parses_single_status_response(): void
    {
        $response = SmsTrafficResponseFactory::createResponse($this->fixture('status_single.xml'));

        $this->assertInstanceOf(SmsTrafficStatusCollectionResponse::class, $response);
        $this->assertFalse($response->hasError());

        $statuses = $response->getStatuses();
        $this->assertCount(1, $statuses);

        $status = $statuses[0];
        $this->assertSame('13844748821563942605296525281335443643', $status->getSmsId());
        $this->assertSame('Delivered', $status->getStatus());
        $this->assertNull($status->getError());
        $this->assertFalse($status->hasError());
        $this->assertSame('2020-05-09 14:11:39', $status->getSubmissionDate());
        $this->assertSame('2020-05-09 14:11:39', $status->getSendDate());
        $this->assertSame('2020-05-09 14:12:00', $status->getLastStatusChangeDate());
    }

    public function test_parses_multiple_status_response(): void
    {
        $response = SmsTrafficResponseFactory::createResponse($this->fixture('status_multiple.xml'));

        $this->assertInstanceOf(SmsTrafficStatusCollectionResponse::class, $response);

        $statuses = $response->getStatuses();
        $this->assertCount(2, $statuses);

        $this->assertSame('8287713301', $statuses[0]->getSmsId());
        $this->assertSame('Expired', $statuses[0]->getStatus());

        $this->assertSame('8287713302', $statuses[1]->getSmsId());
        $this->assertSame('Delivered', $statuses[1]->getStatus());
    }

    public function test_parses_per_item_status_error(): void
    {
        $response = SmsTrafficResponseFactory::createResponse($this->fixture('status_item_error.xml'));

        $this->assertInstanceOf(SmsTrafficStatusCollectionResponse::class, $response);

        $status = $response->getStatuses()[0];
        $this->assertSame('9999999999', $status->getSmsId());
        $this->assertTrue($status->hasError());
        $this->assertSame(
            'no such message or this message does not belong to you',
            $status->getError(),
        );
    }

    public function test_malformed_xml_returns_error_response(): void
    {
        $response = SmsTrafficResponseFactory::createResponse('<reply><unclosed>');

        $this->assertInstanceOf(SmsTrafficErrorResponse::class, $response);
        $this->assertTrue($response->hasError());
    }

    public function test_send_response_is_not_parsed_as_status_response(): void
    {
        $response = SmsTrafficResponseFactory::createResponse($this->fixture('send_success.xml'));

        $this->assertInstanceOf(SmsTrafficSuccessResponse::class, $response);
        $this->assertSame('13844748821563942605296525281335443643', $response->getSmsId());
    }
}
