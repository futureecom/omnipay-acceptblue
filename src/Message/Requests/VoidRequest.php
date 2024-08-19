<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class VoidRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = array();

        $this->validate('transactionReference');

        $data['reference_number'] = (int) $this->getTransactionReference();
        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/void';
    }

    protected function getHttpMethod(): string
    {
        return Request::METHOD_POST;
    }
}
