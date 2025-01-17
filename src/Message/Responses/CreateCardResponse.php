<?php

namespace Omnipay\AcceptBlue\Message\Responses;

use JsonException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\RequestInterface;

class CreateCardResponse extends Response
{
    /**
     * Response constructor.
     *
     * @throws JsonException
     */
    public function __construct(RequestInterface $request, ?string $data)
    {
        parent::__construct($request, $data);
    }

    public function isSuccessful(): bool
    {
        return (isset($this->data['cardRef']) && strlen($this->data['cardRef']) > 1);
    }

    public function getToken(): ?string
    {
        return $this->data['cardRef'] ?? null;
    }

    public function getMessage(): ?string
    {
        return $this->data['error_message'] ?? null;
    }

    public function getError(): ?string
    {
        try {
            return json_encode($this->data['error_details'] ?? [], JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidResponseException("The gateway sent an invalid response.");
        }
    }
}
