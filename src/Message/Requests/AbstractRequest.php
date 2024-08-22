<?php

namespace Omnipay\AcceptBlue\Message\Requests;

use JsonException;
use Omnipay\AcceptBlue\Message\Responses\Response;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    protected string $liveEndpoint = 'https://api.accept.blue/v2';

    protected string $testEndpoint = 'https://api.develop.accept.blue/api/v2';

    public function getApiSourceKey(): ?string
    {
        return $this->getParameter('apiSourceKey');
    }

    public function setApiSourceKey(string $value): self
    {
        return $this->setParameter('apiSourceKey', $value);
    }

    public function getApiPin(): ?string
    {
        return $this->getParameter('apiPin');
    }

    public function setApiPin(string $value): self
    {
        return $this->setParameter('apiPin', $value);
    }

    public function getNonce(): ?string
    {
        return $this->getParameter('nonce');
    }

    public function setNonce(string $value): self
    {
        return $this->setParameter('nonce', $value);
    }

    public function getSource(): ?string
    {
        return $this->getParameter('source');
    }

    public function setSource(string $value): self
    {
        return $this->setParameter('source', $value);
    }

    public function getCapture(): bool
    {
        return $this->getParameter('capture') ?? false;
    }

    public function setCapture(bool $value): self
    {
        return $this->setParameter('capture', $value);
    }

    public function getSaveCard(): bool
    {
        return $this->getParameter('save_card') ?? true;
    }

    public function setSaveCard(bool $value): self
    {
        return $this->setParameter('save_card', $value);
    }

    public function getCardNumber(): ?string
    {
        return $this->getParameter('card_number');
    }

    public function setCardNumber(string $value): self
    {
        return $this->setParameter('card_number', $value);
    }

    public function getCvv(): ?string
    {
        return $this->getParameter('cvv');
    }

    public function setCvv(string $value): self
    {
        return $this->setParameter('cvv2', $value);
    }

    public function getBillingAddress(): ?string
    {
        return $this->getParameter('billingAddress');
    }

    public function setBillingAddress(string $value): self
    {
        return $this->setParameter('avs_address', $value);
    }

    public function getBillingZip(): ?string
    {
        return $this->getParameter('billingZip');
    }

    public function setBillingZip(string $value): self
    {
        return $this->setParameter('avs_zip', $value);
    }

    public function getExpiryMonth(): ?int
    {
        return (int) $this->getParameter('expiryMonth');
    }

    public function setExpiryMonth(int $value): self
    {
        return $this->setParameter('expiryMonth', $value);
    }

    public function getExpiryYear(): ?int
    {
        return (int) $this->getParameter('expiryYear');
    }

    public function setExpiryYear(int $value): self
    {
        return $this->setParameter('expiryYear', $value);
    }

    public function getEndpoint(): string
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function sendData(mixed $data): ?Response
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->getBearer(),
        ];

        try {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                $headers,
                json_encode($data, JSON_THROW_ON_ERROR)
            );
        } catch (JsonException $e) {
            throw new InvalidRequestException(sprintf("Invalid fields sent %s", print_r($data, true)));
        }
        try {
            return $this->createResponse($httpResponse->getBody()->getContents());
        } catch (JsonException $e) {
            throw new InvalidResponseException(sprintf("Invalid response sent. HTTP Status Code: %s; HTTP Reason: %s", $httpResponse->getStatusCode(), $httpResponse->getReasonPhrase()));
        }
    }

    protected function createResponse(string $data): Response
    {
        return $this->response = new Response($this, $data);
    }

    protected function getPaymentDetails(): ?array
    {
        $data = [];
        $card = $this->getCard();

        if ($this->getNonce()) {
            $data['source'] = 'nonce-' . $this->getNonce();
        } elseif ($this->getCardReference()) {
            $data['source'] = 'tkn-' . $this->getCardReference();
        } elseif ($card instanceof CreditCard) {
            $card->validate();

            $data['card'] = $card->getNumber();
            $data['expiry_month'] = (int) $card->getExpiryMonth();
            $data['expiry_year'] = (int) $card->getExpiryYear();
            $data['cvv2'] = $card->getCvv();
            $data['avs_address'] = $card->getBillingAddress1();
            $data['avs_zip'] = $card->getBillingPostcode();

            return $data;
        }

        $data['expiry_month'] = (int) $this->getExpiryMonth();
        $data['expiry_year'] = (int) $this->getExpiryYear();
        $data['cvv2'] = $this->getCvv();
        $data['avs_address'] = $this->getBillingAddress();
        $data['avs_zip'] = $this->getBillingZip();

        $data = array_filter($data, static fn ($value) => $value !== null && $value !== '');

        return $data;
    }

    protected function getBearer(): string
    {
        $token = sprintf(sprintf('%s:%s', $this->getApiSourceKey(), $this->getApiPin()));
        return sprintf('Basic %s', base64_encode($token));
    }

    abstract protected function getHttpMethod(): string;
}
