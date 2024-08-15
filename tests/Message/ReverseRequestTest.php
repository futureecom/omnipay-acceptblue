<?php

namespace Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\AcceptBlue\Message\Requests\ReverseRequest;

class ReverseRequestTest extends TestCase
{
    protected $request;


    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReverseRequest($this->getHttpClient(), $this->getHttpRequest());

    }

    public function testReverseFull()
    {
        $this->request->initialize(array(
            'transactionReference' =>'1234'
        ));

        $this->setMockHttpResponse('Reverse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
    }

    public function testReversePartial()
    {
        $this->request->initialize(array(
            'transactionReference' => '1234',
            'amount' => 2.00
        ));

        $this->setMockHttpResponse('Reverse.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
    }
}
