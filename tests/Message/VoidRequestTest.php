<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\VoidRequest;
use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    protected VoidRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testVoid(): void
    {
        $this->request->initialize(['transactionReference' => '1234']);

        $this->setMockHttpResponse('Void.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
    }
}
