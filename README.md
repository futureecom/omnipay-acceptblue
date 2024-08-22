# Omnipay: Accept.Blue

**Accept.Blue gateway for the Omnipay payment processing library**

## Installation

Install the gateway using composer:

composer require futureecom/omnipay-acceptblue


## Usage

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('AcceptBlue');
$gateway->setApiSourceKey('your-api-source-key');
$gateway->setApiPin('your-api-pin');
$gateway->setTestMode(true); // Set to false for live transactions

// Authorize a payment using a token
$response = $gateway->authorize([
    'amount' => 10.00,
    'cardReference' => 'token123'
])->send();

if ($response->isSuccessful()) {
    echo "Authorization was successful!";
} else {
    echo "Authorization failed: " . $response->getMessage();
}

// Capture a payment using a token
$response = $gateway->capture([
    'transactionReference' => 12345,
    'cardReference' => 'token123'
])->send();

if ($response->isSuccessful()) {
    echo "Capture was successful!";
} else {
    echo "Capture failed: " . $response->getMessage();
}

// Refund a payment
$response = $gateway->refund([
    'transactionReference' => 435341,
    'amount' => '10.00',
])->send();

if ($response->isSuccessful()) {
    echo "Refund was successful!";
} else {
    echo "Refund failed: " . $response->getMessage();
}

// Void a payment
$response = $gateway->void([
    'transactionReference' => 435341,
])->send();

if ($response->isSuccessful()) {
    echo "Void was successful!";
} else {
    echo "Void failed: " . $response->getMessage();
}

// Tokenize a credit card
$response = $gateway->createCard([
    'card' => [
        'number' => '4111111111111111',
        'expiryMonth' => '6',
        'expiryYear' => '2023',
        'cvv' => '123',
    ],
])->send();

if ($response->isSuccessful()) {
    echo "Tokenization was successful!";
    echo "Token: " . $response->getCardReference();
} else {
    echo "Tokenization failed";
}
```

This implementation includes the `testMode` parameter in the test cases for all transaction types, ensuring that the appropriate endpoints are used when `testMode` is enabled.