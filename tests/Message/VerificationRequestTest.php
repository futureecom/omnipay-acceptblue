<?php


namespace Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\AcceptBlue\Message\Requests\VerificationRequest;

class VerificationRequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {

        parent::setUp();

    $this->request = new VerificationRequest($this->getHttpClient(), $this->getHttpRequest());

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

        $this->request->initialize(array(
            'card' => $card
        ));
        $this->setMockHttpResponse('Verification.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 'A');
        $this->assertMatchesRegularExpression("/[A-Z]{2}[A-Z0-9]{14}/", $response->getToken());

    }
}
