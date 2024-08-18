<?php

namespace Omnipay\AcceptBlue\Message\Requests;

class ReverseRequest extends AbstractRequest
{
    public function getData(): array
    {
        $this->validate('transactionReference');
        $card = $this->getCard();

        $data['reference_number'] = (int) $this->getTransactionReference();

        if ($this->getAmount()) {
            $data['amount'] = (float) $this->getAmount();
        }

        return $data;
    }

    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/transactions/reversal';
    }

    protected function getHttpMethod(): string
    {
        return 'POST';
    }
}
