<?php


namespace Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\AcceptBlue\Message\Requests\VoidRequest;

class VoidRequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());

    }

    public function testVoid()
    {
        $this->request->initialize(array(
            'transactionReference' => '1234'
        ));

        $this->setMockHttpResponse('Void.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
    }
}
