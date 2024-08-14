<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Omnipay\Common\CreditCard;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');
        $card = $this->getCard();

        $data['reference_number'] = (int) $this->getTransactionReference();

        if ($this->getAmount()) {
            $data['amount'] = (float) $this->getAmount();
        }

        if ($card instanceof CreditCard) {
            if($card->getCvv()) {
                $data['cvv2'] = $card->getCvv();
            }
        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/transactions/refund';
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }
}