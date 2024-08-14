<?php

namespace Tests\Message;

use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class CreditRequestTest extends TestCase
{
    protected $gateway;

    protected $token;

    protected function setUp(): void
    {

        $this->gateway = Omnipay::create('AcceptBlue');
        $this->gateway->setApiSourceKey(getenv('ACCEPT_BLUE_SOURCE_KEY'));
        $this->gateway->setApiPin(getenv('ACCEPT_BLUE_API_PIN'));
        $this->gateway->setTestMode(true);

        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '12',
            'expiryYear' => '2026',
        ];
        $data = array('card' => $card);

        $response = $this->gateway->createCard($data)->send();

        $this->token = $response->getToken();
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

        $data = array('amount' => 5.00, 'card' => $card);

        $response = $this->gateway->credit($data)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }

    public function testCreditWithToken()
    {
        // Build the authorization request data with a credit card
        $data = array('amount' => 5.00, 'cardReference' => $this->token);
        // Send the request
        $response = $this->gateway->credit($data)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }
}