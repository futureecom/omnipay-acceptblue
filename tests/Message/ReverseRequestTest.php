<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\ReverseRequest;
use Omnipay\Tests\TestCase;

class ReverseRequestTest extends TestCase
{
    protected ReverseRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReverseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testReverseFull(): void
    {
        $this->request->initialize(['transactionReference' => '1234']);

        $this->setMockHttpResponse('Reverse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
    }

    public function testReversePartial(): void
    {
        $this->request->initialize(
            [
                'transactionReference' => '1234',
                'amount' => 2.00,
            ]
        );

        $this->setMockHttpResponse('Reverse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
    }
}
