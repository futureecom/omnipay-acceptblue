<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class ReverseRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = array();

        $this->validate('transactionReference');

        $data['reference_number'] = (int) $this->getTransactionReference();

        if ($this->getAmount()) {
            $data['amount'] = $this->getAmount() ?? (float) $this->getAmount();
        }

        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/reversal';
    }

    protected function getHttpMethod(): string
    {
        return Request::METHOD_POST;
    }
}
