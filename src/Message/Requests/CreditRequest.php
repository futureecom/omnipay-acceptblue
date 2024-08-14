<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Omnipay\Common\CreditCard;

class CreditRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount');
        $card = $this->getCard();

        $data['amount'] = (float) $this->getAmount();
        if ($this->getCardReference()) {
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

        if ($this->getTransactionId()) {
            $data['transaction_details']['order_number'] = $this->getTransactionId();
        }
        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/transactions/credit';
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }
}
