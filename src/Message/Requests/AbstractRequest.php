<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use Omnipay\AcceptBlue\Message\Responses\Response;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    protected $liveEndpoint = 'https://api.accept.blue/v2';

    protected $testEndpoint = 'https://api.develop.accept.blue/api/v2';

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

    public function getNonce()
    {
        return $this->getParameter('nonce');
    }

    public function setNonce($value)
    {
        return $this->setParameter('nonce', $value);
    }

    public function getSource()
    {
        return $this->getParameter('source');
    }

    public function setSource($value)
    {
        return $this->setParameter('source', $value);
    }

    public function getCapture()
    {
        return $this->getParameter('capture');
    }

    public function setCapture($value)
    {
        return $this->setParameter('capture', $value);
    }

    public function getSaveCard()
    {
        return $this->getParameter('save_card');
    }

    public function setSaveCard($value)
    {
        return $this->setParameter('save_card', $value);
    }

    public function getCardNumber()
    {
        return $this->getParameter('card_number');
    }

    public function setCardNumber($value)
    {
        return $this->setParameter('card_number', $value);
    }

    public function getCvv()
    {
        return $this->getParameter('cvv');
    }

    public function setCvv($value)
    {
        return $this->setParameter('cvv2', $value);
    }

    public function getBillingAddress()
    {
        return $this->getParameter('billingAddress');
    }

    public function setBillingAddress($value)
    {
        return $this->setParameter('avs_address', $value);
    }

    public function getBillingZip()
    {
        return $this->getParameter('billingZip');
    }

    public function setBillingZip($value)
    {
        return $this->setParameter('avs_zip', $value);
    }

    public function getExpiryMonth()
    {
        return $this->getParameter('expiryMonth');
    }

    public function setExpiryMonth($value)
    {
        return $this->setParameter('expiryMonth', $value);
    }

    public function getExpiryYear()
    {
        return $this->getParameter('expiryYear');
    }

    public function setExpiryYear($value)
    {
        return $this->setParameter('expiryYear', $value);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->getApiSourceKey() . ':' . $this->getApiPin()),
        ];
        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            json_encode($data)
        );

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    protected function createResponse(string $data)
    {
        return $this->response = new Response($this, $data);
    }

    abstract protected function getHttpMethod();
}
