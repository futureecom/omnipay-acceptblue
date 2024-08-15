<?php


namespace Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\AcceptBlue\Message\Requests\CreditRequest;

class CreditRequestTest extends TestCase
{
    protected $request;
    
    protected function setUp(): void
    {

        parent::setUp();

        $this->request = new CreditRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCreditWithCreditCard()
    {
        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '12',
            'expiryYear' => '2026',
            'cvv' => '123',
            'billingAddress1' => '123 Test St',
            'billingCity' => 'Test City',
            'billingPostcode' => '10001',
            'billingState' => 'NY',
            'billingCountry' => 'US',
        ];

        $this->request->initialize(array(
            'card' => $card,
            'amount' => 5.00
        ));
        $this->setMockHttpResponse('Credit.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }

    public function testCreditWithToken()
    {
        $this->request->initialize(array(
            'cardReference' => 'abcd',
            'amount' => 5.00
        ));
        $this->setMockHttpResponse('Credit.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
        
    }
}
