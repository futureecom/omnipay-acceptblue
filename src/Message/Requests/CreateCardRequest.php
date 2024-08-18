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
            $data['expiry_month'] = $this->getExpiryMonth();
            $data['expiry_year'] = $this->getExpiryYear();
        } elseif ($card instanceof CreditCard) {
            $card->validate();
            $data['card'] = $card->getNumber();
            $data['expiry_month'] = $card->getExpiryMonth();
            $data['expiry_year'] = $card->getExpiryYear();
        }
        return $data;
    }

    public function getCardType(): string
    {
        return $this->getParameter('cardType');
    }

    public function setCardType($value): self
    {
        return $this->setParameter('cardType', $value);
    }

    public function getLast4(): string
    {
        return $this->getParameter('last4');
    }

    public function setLast4($value): self
    {
        return $this->setParameter('last4', $value);
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/saved-cards';
    }

    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    protected function createResponse(string $data)
    {
        return $this->response = new CreateCardResponse($this, $data);
    }
}
