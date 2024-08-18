<?php

namespace Omnipay\AcceptBlue\Message\Requests;

class VoidRequest extends AbstractRequest
{
    public function getData(): array
    {
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
        return 'POST';
    }
}
