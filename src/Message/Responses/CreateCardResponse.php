<?php

namespace Omnipay\AcceptBlue\Message\Responses;

use JsonException;
use Omnipay\Common\Message\RequestInterface;

class CreateCardResponse extends AbstractResponse
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
        if (isset($this->data['cardRef']) && strlen($this->data['cardRef']) > 1) {
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getToken(): ?string
    {
        return $this->data['cardRef'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): ?string
    {
        return $this->data['error_message'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getError(): ?string
    {
        return json_encode($this->data['error_details']) ?? null;
    }
}
