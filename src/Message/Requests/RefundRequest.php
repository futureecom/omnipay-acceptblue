<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Omnipay\Common\CreditCard;
use Symfony\Component\HttpFoundation\Request;

class RefundRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = array();

        $this->validate('transactionReference');

        $card = $this->getCard();

        $data['reference_number'] = (int) $this->getTransactionReference();

        if ($this->getAmount()) {
            $data['amount'] = (float) $this->getAmount();
        }

        if ($card instanceof CreditCard && $card->getCvv()) {
            $data['cvv2'] = $card->getCvv();
        }

        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/refund';
    }

    protected function getHttpMethod(): string
    {
        return Request::METHOD_POST;
    }
}
