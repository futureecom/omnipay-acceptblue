<?php

namespace Tests\Message;

use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class VerificationRequestTest extends TestCase
{
    protected $gateway;

    protected function setUp(): void
    {

        $this->gateway = Omnipay::create('AcceptBlue');
        $this->gateway->setApiSourceKey(getenv('ACCEPT_BLUE_SOURCE_KEY'));
        $this->gateway->setApiPin(getenv('ACCEPT_BLUE_API_PIN'));
        $this->gateway->setTestMode(true);

    }

    public function testVerification()
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

        $data = array('card' => $card);

        $response = $this->gateway->verify($data)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
        $this->assertMatchesRegularExpression("/[A-Z]{2}[A-Z0-9]{14}/", $response->getToken());

    }
}
