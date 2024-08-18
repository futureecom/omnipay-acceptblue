<?php

namespace Tests\Message;

use Omnipay\AcceptBlue\Message\Requests\VerificationRequest;
use Omnipay\Tests\TestCase;

class VerificationRequestTest extends TestCase
{
    protected VerificationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new VerificationRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testVerification(): void
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

        $this->request->initialize(['card' => $card]);
        $this->setMockHttpResponse('Verification.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('A', $response->getCode());
        $this->assertMatchesRegularExpression("/[A-Z]{2}[A-Z0-9]{14}/", $response->getToken());

    }
}
