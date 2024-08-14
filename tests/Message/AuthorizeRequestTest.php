<?php

namespace Tests\Message;

use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
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

    public function testAuthorizeWithCreditCard()
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

        $response = $this->gateway->authorize($data)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
        $this->assertMatchesRegularExpression("/[A-Z]{2}[A-Z0-9]{14}/", $response->getToken());

    }

    public function testAuthorizeWithToken()
    {
        // Build the authorization request data with a credit card
        $data = array('amount' => 5.00, 'cardReference' => $this->token);
        // Send the request
        $response = $this->gateway->authorize($data)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }
}
