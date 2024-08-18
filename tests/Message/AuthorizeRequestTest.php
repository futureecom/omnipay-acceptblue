<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\AuthorizeRequest;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());

    }

    public function testAuthorizeWithCreditCard(): void
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
            'amount' => 5.00,
        ));
        $this->setMockHttpResponse('Authorize.txt');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
        $this->assertMatchesRegularExpression("/[A-Z]{2}[A-Z0-9]{14}/", $response->getToken());

    }

    public function testAuthorizeWithToken(): void
    {
        $this->request->initialize(array(
            'cardReference' => 'abcd',
            'amount' => 5.00,
        ));
        $this->setMockHttpResponse('Authorize.txt');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
        $this->assertGreaterThanOrEqual(1, $response->getTransactionReference());
    }
}
