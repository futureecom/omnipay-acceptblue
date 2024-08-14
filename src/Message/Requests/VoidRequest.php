<?php

namespace Omnipay\AcceptBlue\Message\Requests;

class VoidRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');
        $data['reference_number'] = (int) $this->getTransactionReference();
        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/transactions/void';
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }
}
