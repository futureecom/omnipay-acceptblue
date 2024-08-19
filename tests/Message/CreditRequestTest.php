<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\CreditRequest;
use Omnipay\Tests\TestCase;

class CreditRequestTest extends TestCase
{
    protected CreditRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreditRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCreditWithCreditCard(): void
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

        $this->request->initialize(
            [
                'apiSourceKey' => 'abcd',
                'apiPin' => '1234',
                'card' => $card,
                'amount' => 5.00,
            ]
        );
        $this->setMockHttpResponse('Credit.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }

    public function testCreditWithToken()
    {
        $this->request->initialize(
            [
                'apiSourceKey' => 'abcd',
                'apiPin' => '1234',
                'cardReference' => 'abcd',
                'amount' => 5.00,
            ]
        );
        $this->setMockHttpResponse('Credit.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }
}
