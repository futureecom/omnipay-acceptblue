<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use JsonException;
use Omnipay\AcceptBlue\Message\Responses\Response;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    protected string $liveEndpoint = 'https://api.accept.blue/v2';

    protected string $testEndpoint = 'https://api.develop.accept.blue/api/v2';

    public function getApiSourceKey(): ?string
    {
        return $this->getParameter('apiSourceKey');
    }

    public function setApiSourceKey($value): self
    {
        return $this->setParameter('apiSourceKey', $value);
    }

    public function getApiPin(): ?string
    {
        return $this->getParameter('apiPin');
    }

    public function setApiPin($value): self
    {
        return $this->setParameter('apiPin', $value);
    }

    public function getNonce(): ?string
    {
        return $this->getParameter('nonce');
    }

    public function setNonce($value): self
    {
        return $this->setParameter('nonce', $value);
    }

    public function getSource(): ?string
    {
        return $this->getParameter('source');
    }

    public function setSource($value): self
    {
        return $this->setParameter('source', $value);
    }

    public function getCapture(): ?string
    {
        return $this->getParameter('capture');
    }

    public function setCapture($value): self
    {
        return $this->setParameter('capture', $value);
    }

    public function getSaveCard(): ?string
    {
        return $this->getParameter('save_card');
    }

    public function setSaveCard($value): self
    {
        return $this->setParameter('save_card', $value);
    }

    public function getCardNumber(): ?string
    {
        return $this->getParameter('card_number');
    }

    public function setCardNumber($value): self
    {
        return $this->setParameter('card_number', $value);
    }

    public function getCvv(): ?string
    {
        return $this->getParameter('cvv');
    }

    public function setCvv($value): self
    {
        return $this->setParameter('cvv2', $value);
    }

    public function getBillingAddress(): ?string
    {
        return $this->getParameter('billingAddress');
    }

    public function setBillingAddress($value): self
    {
        return $this->setParameter('avs_address', $value);
    }

    public function getBillingZip(): ?string
    {
        return $this->getParameter('billingZip');
    }

    public function setBillingZip($value): self
    {
        return $this->setParameter('avs_zip', $value);
    }

    public function getExpiryMonth(): ?string
    {
        return $this->getParameter('expiryMonth');
    }

    public function setExpiryMonth($value): self
    {
        return $this->setParameter('expiryMonth', $value);
    }

    public function getExpiryYear(): ?string
    {
        return $this->getParameter('expiryYear');
    }

    public function setExpiryYear($value): self
    {
        return $this->setParameter('expiryYear', $value);
    }

    public function getEndpoint(): string
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function sendData($data): ?Response
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => sprintf('Basic %s', base64_encode(sprintf('%s:%s', $this->getApiSourceKey(), $this->getApiPin()))),
        ];

        try {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                $headers,
                json_encode($data)
            );
        } catch (JsonException $e) {
            return null;
        }

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    protected function createResponse(string $data): Response
    {
        return $this->response = new Response($this, $data);
    }

    protected function getPaymentDetails(): ?array
    {
        $card = $this->getCard();

        if ($this->getNonce()) {
            $data['source'] = 'nonce-' . $this->getNonce();
        } elseif ($this->getCardReference()) {
            $data['source'] = 'tkn-' . $this->getCardReference();
        } elseif ($card instanceof CreditCard) {

            $card->validate();

            $data['card'] = $card->getNumber();
            $data['expiry_month'] = $card->getExpiryMonth();
            $data['expiry_year'] = $card->getExpiryYear();
            $data['cvv2'] = $card->getCvv();
            $data['avs_address'] = $card->getBillingAddress1();
            $data['avs_zip'] = $card->getBillingPostcode();
        }

        return $data;
    }

    abstract protected function getHttpMethod(): string;
}
