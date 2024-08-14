<?php

namespace Tests\Concerns;

use Omnipay\AcceptBlue\Message\Responses\Response;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\ResponseInterface;
use PHPUnit\Framework\Assert;

/**
 * Trait TransactionStatus.
 */
trait TransactionStatus
{
    /**
     * @param Response&ResponseInterface $response
     */
    protected function assertTransaction(
        ResponseInterface $response,
        ?string $reference,
        ?string $message,
        ?string $code,
        bool $isSuccess = true,
        bool $isRedirect = false,
        bool $isCancelled = false,
        ?string $redirectUrl = null
    ): void {
        Assert::assertEquals(
            [
                'cancelled' => $isCancelled,
                'code' => $code,
                'message' => $message,
                'redirect' => $isRedirect,
                'redirect_url' => $redirectUrl,
                'success' => $isSuccess,
                'transaction_reference' => $reference,
            ],
            [
                'cancelled' => $response->isCancelled(),
                'code' => $response->getCode(),
                'message' => $response->getMessage(),
                'redirect' => $response->isRedirect(),
                'redirect_url' => $this->getRedirectUrlFromResponse($response),
                'success' => $response->isSuccessful(),
                'transaction_reference' => $response->getTransactionReference(),
            ],
        );
    }

    private function getRedirectUrlFromResponse(ResponseInterface $response): ?string
    {
        return $response instanceof RedirectResponseInterface ? $response->getRedirectUrl() : null;
    }
}
