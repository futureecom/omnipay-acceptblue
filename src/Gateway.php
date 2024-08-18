<?php

namespace Omnipay\AcceptBlue;

use Omnipay\AcceptBlue\Message\Requests\AuthorizeRequest;
use Omnipay\AcceptBlue\Message\Requests\CaptureRequest;
use Omnipay\AcceptBlue\Message\Requests\CreateCardRequest;
use Omnipay\AcceptBlue\Message\Requests\CreditRequest;
use Omnipay\AcceptBlue\Message\Requests\RefundRequest;
use Omnipay\AcceptBlue\Message\Requests\ReverseRequest;
use Omnipay\AcceptBlue\Message\Requests\VerificationRequest;
use Omnipay\AcceptBlue\Message\Requests\VoidRequest;
use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'AcceptBlue';
    }

    public function getDefaultParameters(): array
    {
        return [
            'apiSourceKey' => '',
            'apiPin' => '',
            'testMode' => false,
        ];
    }

    public function getApiSourceKey(): string
    {
        return $this->getParameter('apiSourceKey');
    }

    public function setApiSourceKey($value): self
    {
        return $this->setParameter('apiSourceKey', $value);
    }

    public function getApiPin(): string
    {
        return $this->getParameter('apiPin');
    }

    public function setApiPin($value): self
    {
        return $this->setParameter('apiPin', $value);
    }

    public function authorize(array $parameters = []): AuthorizeRequest
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function capture(array $parameters = []): CaptureRequest
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    public function refund(array $parameters = []): RefundRequest
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    public function reverse(array $parameters = []): ReverseRequest
    {
        return $this->createRequest(ReverseRequest::class, $parameters);
    }

    public function credit(array $parameters = []): CreditRequest
    {
        return $this->createRequest(CreditRequest::class, $parameters);
    }

    public function void(array $parameters = []): VoidRequest
    {
        return $this->createRequest(VoidRequest::class, $parameters);
    }

    public function createCard(array $parameters = []): CreateCardRequest
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    public function verify(array $parameters = []): VerificationRequest
    {
        return $this->createRequest(VerificationRequest::class, $parameters);
    }
}
