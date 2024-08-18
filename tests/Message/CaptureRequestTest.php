<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\CaptureRequest;
use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{
    protected CaptureRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCapture(): void
    {

        $this->request->initialize(['transactionReference' => '1234']);

        $this->setMockHttpResponse('Capture.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
    }
}
