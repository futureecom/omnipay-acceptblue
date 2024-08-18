<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class CaptureRequest extends AbstractRequest
{
    public function getData(): array
    {
        $this->validate('transactionReference');

        $data['reference_number'] = (int) $this->getTransactionReference();

        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/capture';
    }

    protected function getHttpMethod(): string
    {
        return Request::METHOD_POST;
    }
}
