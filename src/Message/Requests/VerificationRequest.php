<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class VerificationRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = [];

        $data['save_card'] = !$this->getSaveCard() ? false : true;
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
        return parent::getEndpoint() . '/transactions/verify';
    }

    protected function getHttpMethod(): string
    {
        return Request::METHOD_POST;
    }
}
