<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class AuthorizeRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = [];

        $this->validate('amount');
        $data['amount'] = (float) $this->getAmount();

        $data = [
            ...$data,
            ...$this->getPaymentDetails(),
        ];

        $data['capture'] = $this->getCapture();
        $data['save_card'] = $this->getSaveCard();

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
        return Request::METHOD_POST;
    }
}
