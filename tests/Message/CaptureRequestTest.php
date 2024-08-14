<?php

namespace Tests\Message;

use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{
    protected $gateway;

    protected $transactionReference;

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
            'cvv' => '123',
            'billingAddress1' => '123 Test St',
            'billingCity' => 'Test City',
            'billingPostcode' => '10001',
            'billingState' => 'NY',
            'billingCountry' => 'US',
        ];
        $data = array('amount' => 5.00, 'card' => $card);

        $response = $this->gateway->authorize($data)->send();

        $this->transactionReference = $response->getTransactionReference();
    }

    public function testCapture()
    {
        $data = array('transactionReference' => $this->transactionReference);

        $response = $this->gateway->capture($data)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
    }
}
