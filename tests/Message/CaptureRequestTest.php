<?php


namespace Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\AcceptBlue\Message\Requests\CaptureRequest;

class CaptureRequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCapture()
    {
        
        $this->request->initialize(array('transactionReference' => '1234'));

        $this->setMockHttpResponse('Capture.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
    }
}
