<?php


namespace Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\AcceptBlue\Message\Requests\CreateCardRequest;

class CreateCardRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCreateCard(): void
    {
        $card = [
            'number' => '4111111111111111',
            'expiryMonth' => '12',
            'expiryYear' => '2026',
        ];
        $this->request->initialize(array(
            'card' => $card
        ));
        $this->setMockHttpResponse('CreateCard.txt');
        $response = $this->request->send();
        $this->assertMatchesRegularExpression("/[A-Z]{2}[A-Z0-9]{14}/", $response->getToken());
    }
}
