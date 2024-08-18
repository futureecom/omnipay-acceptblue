<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Omnipay\Common\CreditCard;

class AuthorizeRequest extends AbstractRequest
{
    public function getData(): array
    {
        $this->validate('amount');
        $data['amount'] = (float) $this->getAmount();

        $card = $this->getCard();

        if ($this->getNonce()) {
            $this->validate('nonce');
            $data['source'] = 'nonce-' . $this->getNonce();
        } elseif ($this->getCardReference()) {
            $this->validate('cardReference');
            $data['source'] = 'tkn-' . $this->getCardReference();
        } elseif ($card instanceof CreditCard) {
            $card->validate();
            $data['card'] = $card->getNumber();
            $data['expiry_month'] = $card->getExpiryMonth();
            $data['expiry_year'] = $card->getExpiryYear();
            $data['cvv2'] = $card->getCvv();
            $data['avs_address'] = $card->getBillingAddress1();
            $data['avs_zip'] = $card->getBillingPostcode();
        }

        $data['capture'] = ($this->getCapture() === true) ? $this->getCapture() : false;
        $data['save_card'] = ($this->getSaveCard() === false) ? $this->getSaveCard() : true;

        if ($this->getTransactionId()) {
            $data['transaction_details']['order_number'] = $this->getTransactionId();
        }
        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/charge';
    }

    protected function getHttpMethod(): string
    {
        return 'POST';
    }
}
