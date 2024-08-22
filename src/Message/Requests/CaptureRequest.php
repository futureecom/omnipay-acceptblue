<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Symfony\Component\HttpFoundation\Request;

class CaptureRequest extends AbstractRequest
{
    public function getData(): array
    {
        $this->validate('transactionReference');

        return ['reference_number' => (int) $this->getTransactionReference()];
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
