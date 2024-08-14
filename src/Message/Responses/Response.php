<?php

namespace Omnipay\AcceptBlue\Message\Responses;

use JsonException;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Response constructor.
     *
     * @throws JsonException
     */
    public function __construct(RequestInterface $request, ?string $data)
    {
        parent::__construct($request, json_decode($data, true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return ($this->data['status'] ?? '') === 'Approved';
    }

    /**
     * @inheritDoc
     */
    public function getCode(): ?string
    {
        return $this->data['status_code'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference(): ?string
    {
        $request_data = $this->request->getParameters();

        return $this->data['reference_number'] ?? $this->data['reference_number'] ?? $request_data['transactionReference'];
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): ?string
    {
        return $this->data['error_message'] ?? null;
    }

    public function isRedirect(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getToken(): ?string
    {
        return $this->data['card_ref'] ?? null;
    }
}
