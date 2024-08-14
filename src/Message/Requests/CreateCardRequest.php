<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Omnipay\AcceptBlue\Message\Responses\CreateCardResponse;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

class CreateCardRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $card = $this->getCard();

        if ($this->getNonce()) {
            $data['source'] = 'nonce-' . $this->getNonce();
        } elseif ($card instanceof CreditCard) {
            $card->validate();
            $data['card'] = $card->getNumber();
            $data['expiry_month'] = $card->getExpiryMonth();
            $data['expiry_year'] = $card->getExpiryYear();
        }
        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/saved-cards';
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    protected function createResponse(string $data)
    {
        return $this->response = new CreateCardResponse($this, $data);
    }
}
