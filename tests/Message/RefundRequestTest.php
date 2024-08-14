<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\RefundRequest;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    protected $gateway;

    protected $transactionReference;

    protected $request;

    protected function setUp(): void
    {

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

    }

    public function testRefundFull()
    {

        $this->request->initialize(
            array(
                'transactionReference' => '1234',
            )
        );
        $this->setMockHttpResponse('Refund.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');

    }

    public function testRefundPartial()
    {
        $this->request->initialize(
            array(
                'transactionReference' => '1234',
                'amount' => 2.00,
            )
        );
        $this->setMockHttpResponse('Refund.txt');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
    }
}
