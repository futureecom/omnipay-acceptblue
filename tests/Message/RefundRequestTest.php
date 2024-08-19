<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\RefundRequest;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    protected RefundRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testRefundFull(): void
    {
        $this->request->initialize(
            [  'apiSourceKey' => 'abcd',
                'apiPin' => '1234',
                'transactionReference' => '1234',
            ]
        );
        $this->setMockHttpResponse('Refund.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
    }

    public function testRefundPartial(): void
    {
        $this->request->initialize(
            [
                'apiSourceKey' => 'abcd',
                'apiPin' => '1234',
                'transactionReference' => '1234',
                'amount' => 2.00,
            ]
        );
        $this->setMockHttpResponse('Refund.txt');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
    }
}
