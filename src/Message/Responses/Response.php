<?php

namespace Omnipay\AcceptBlue\Message\Responses;

use JsonException;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    /**
     * Response constructor.
     *
     * @throws JsonException
     */
    public function __construct(RequestInterface $request, ?string $data)
    {
        parent::__construct($request, json_decode($data, true, 512, JSON_THROW_ON_ERROR));
    }

    public function isSuccessful(): bool
    {
        return ($this->data['status'] ?? '') === AbstractResponse::STATUS_APPROVED;
    }

    public function getCode(): ?string
    {
        return $this->data['status_code'] ?? null;
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['reference_number'] ?? null;
    }

    public function getMessage(): ?string
    {
        return $this->data['error_message'] ?? null;
    }

    public function getToken(): ?string
    {
        return $this->data['card_ref'] ?? null;
    }
}
