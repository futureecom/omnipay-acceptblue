<?php

namespace Tests;

use Omnipay\AcceptBlue\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setApiSourceKey(getenv('ACCEPT_BLUE_SOURCE_KEY'));
        $this->gateway->setApiPin(getenv('ACCEPT_BLUE_API_PIN'));
        $this->gateway->setTestMode(true);

    }

    public function testGatewayName(): void
    {
        $this->assertSame('AcceptBlue', $this->gateway->getName());
    }

    public function testAuthorize()
    {

        $request = $this->gateway->authorize([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'token123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\AuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('token123', $request->getToken());
        $this->assertSame('your-api-pin', $request->getApiPin());
    }

    public function testAuthorizeTestMode()
    {
        $this->gateway->setTestMode(true);
        $request = $this->gateway->authorize([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'token123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\AuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('token123', $request->getToken());
        $this->assertSame('your-api-pin', $request->getApiPin());
        $this->assertSame('https://api.develop.accept.blue/api/v2/transactions/charge', $request->getEndpoint());
    }

    public function testCapture()
    {
        $request = $this->gateway->capture([
            'transactionReference' => 'abc123',
            'token' => 'token123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\CaptureRequest', $request);
        $this->assertSame('abc123', $request->getTransactionReference());
        $this->assertSame('token123', $request->getToken());
        $this->assertSame('your-api-pin', $request->getApiPin());
    }

    public function testCaptureTestMode()
    {
        $this->gateway->setTestMode(true);
        $request = $this->gateway->capture([
            'transactionReference' => 'abc123',
            'token' => 'token123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\CaptureRequest', $request);
        $this->assertSame('abc123', $request->getTransactionReference());
        $this->assertSame('token123', $request->getToken());
        $this->assertSame('your-api-pin', $request->getApiPin());
        $this->assertSame('https://api.develop.accept.blue/api/v2/transactions/capture', $request->getEndpoint());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund([
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\RefundRequest', $request);
        $this->assertSame('abc123', $request->getTransactionReference());
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('your-api-pin', $request->getApiPin());
    }

    public function testRefundTestMode()
    {
        $this->gateway->setTestMode(true);
        $request = $this->gateway->refund([
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\RefundRequest', $request);
        $this->assertSame('abc123', $request->getTransactionReference());
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('your-api-pin', $request->getApiPin());
        $this->assertSame('https://api.develop.accept.blue/api/v2/transactions/refund', $request->getEndpoint());
    }

    public function testVoid()
    {
        $request = $this->gateway->void([
            'transactionReference' => 'abc123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\VoidRequest', $request);
        $this->assertSame('abc123', $request->getTransactionReference());
        $this->assertSame('your-api-pin', $request->getApiPin());
    }

    public function testVoidTestMode()
    {
        $this->gateway->setTestMode(true);
        $request = $this->gateway->void([
            'transactionReference' => 'abc123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\VoidRequest', $request);
        $this->assertSame('abc123', $request->getTransactionReference());
        $this->assertSame('your-api-pin', $request->getApiPin());
        $this->assertSame('https://api.develop.accept.blue/api/v2/transactions/void', $request->getEndpoint());
    }

    public function testCreateCard()
    {
        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '6',
            'expiryYear' => '2023',
            'cvv' => '123',
        ];

        $request = $this->gateway->createCard(['card' => $card]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\CreateCardRequest', $request);
    }

    public function testReverse()
    {
        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '6',
            'expiryYear' => '2023',
            'cvv' => '123',
        ];

        $request = $this->gateway->reverse(['card' => $card]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\ReverseRequest', $request);
    }

    public function testCredit()
    {
        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '6',
            'expiryYear' => '2023',
            'cvv' => '123',
        ];

        $request = $this->gateway->credit(['card' => $card]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\CreditRequest', $request);
    }

    public function testVerification()
    {
        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '6',
            'expiryYear' => '2023',
            'cvv' => '123',
        ];

        $request = $this->gateway->verify(['card' => $card]);
        $this->assertInstanceOf('Omnipay\AcceptBlue\Message\Requests\VerificationRequest', $request);
    }

    public function testTestMode()
    {
        $this->gateway->setTestMode(true);

        $request = $this->gateway->authorize([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'token123',
            'apiPin' => 'your-api-pin',
        ]);
        $this->assertSame('https://api.develop.accept.blue/api/v2/transactions/charge', $request->getEndpoint());
    }
}
