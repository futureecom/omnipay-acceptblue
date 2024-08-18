<?php

namespace Omnipay\AcceptBlue\Message\Responses;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;

abstract class AbstractResponse extends OmnipayAbstractResponse
{
    public const STATUS_SUCCESS = 'success';

    public const STATUS_APPROVED = 'Approved';

    public function isSuccessful(): bool
    {
        return $this->data['status'] ?? '' === AbstractResponse::STATUS_SUCCESS;
    }
}
