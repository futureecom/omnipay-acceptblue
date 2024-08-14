<?php

namespace Omnipay\AcceptBlue;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'AcceptBlue';
    }

    public function getDefaultParameters()
    {
        return [
            'apiSourceKey' => '',
            'apiPin' => '',
            'testMode' => false,
        ];
    }

    public function getApiSourceKey()
    {
        return $this->getParameter('apiSourceKey');
    }

    public function setApiSourceKey($value)
    {
        return $this->setParameter('apiSourceKey', $value);
    }

    public function getApiPin()
    {
        return $this->getParameter('apiPin');
    }

    public function setApiPin($value)
    {
        return $this->setParameter('apiPin', $value);
    }

    public function authorize(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\CaptureRequest', $parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\RefundRequest', $parameters);
    }

    public function reverse(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\ReverseRequest', $parameters);
    }

    public function credit(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\CreditRequest', $parameters);
    }

    public function void(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\VoidRequest', $parameters);
    }

    public function createCard(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\CreateCardRequest', $parameters);
    }

    public function verify(array $parameters = [])
    {
        return $this->createRequest('Omnipay\AcceptBlue\Message\Requests\VerificationRequest', $parameters);
    }
}
