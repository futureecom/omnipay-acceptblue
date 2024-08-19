<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class CreditRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = array();

        $this->validate('amount');
        $data['amount'] = (float) $this->getAmount();

        $data = [
            ...$data,
            ...$this->getPaymentDetails(),
        ];

        if ($this->getTransactionId()) {
            $data['transaction_details']['order_number'] = $this->getTransactionId();
        }
        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/credit';
    }

    protected function getHttpMethod(): string
    {
        return Request::METHOD_POST;
    }
}
