# Ariomex API Integration

This README file documents how to use the Ariomex API SDK to interact with various API endpoints. The Ariomex SDK provides methods to interact with general, account, wallet, bank, history, and order API endpoints.

You can find the API documentation at [https://apidoc.ariomex.com](https://apidoc.ariomex.com).

## Getting Started

To use the Ariomex API, you need to include the Ariomex SDK in your project and create an instance of the Ariomex class with your API key and secret.

### Prerequisites

- PHP 7.0 or later
- Ariomex API SDK (ariomex.php)

### Installation

Ensure the `ariomex.php` file is available in your project directory.

### Initialization

```php
// Include the Ariomex API SDK class
require_once 'ariomex.php';
// Create an instance of the Ariomex class
$ariomex = new Ariomex('your_api_key', 'your_api_secret');
```

## Usage

### General

```php
// Example usage of the swagger method
$swagger = $ariomex->general->swagger();

// Example usage of the ping method
$pingResponse = $ariomex->general->ping();

// Example usage of the time method
$serverTime = $ariomex->general->time();

// Example usage of the exchange_info method
$exchangeInfo = $ariomex->general->exchange_info('btcusdt');

// Example usage of the coins_info method
$coinsInfo = $ariomex->general->coins_info('btc');

// Example usage of the orderbook method
$orderBook = $ariomex->general->orderbook('btcusdt');

// Example usage of the last_trades method
$lastTrades = $ariomex->general->last_trades('btcusdt');

// Example usage of the last_prices method
$lastPrices = $ariomex->general->last_prices('btcusdt');

// Example usage of the candlesticks method
$candlesticks = $ariomex->general->candlesticks('btcusdt', '5');
```

### Account

```php
// Example usage of the getAccountInfo method
$accountInfo = $ariomex->account->getAccountInfo();

// Example usage of the getBalance method
$balance = $ariomex->account->getBalance();

// Example usage of the getDustBalance method
$dustBalance = $ariomex->account->getDustBalance();

// Example usage of the convertDustBalance method
$conversionResult = $ariomex->account->convertDustBalance(['btc', 'eth']);
```

### Wallet

```php
// Example usage of the generateDepositAddress method
$generateDepositAddress = $ariomex->wallet->generateDepositAddress();

// Example usage of the getDepositAddress method
$depositAddress = $ariomex->wallet->getDepositAddress();

// Example usage of the withdrawIrt method
$withdrawalResponse = $ariomex->wallet->withdrawIrt('100', 'iban_uuid_here');

// Example usage of the withdrawCrypto method
$withdrawalResponse = $ariomex->wallet->withdrawCrypto('btc', 'btc', '1', 'address_uuid_here', 'optional_memo');

// Example usage of the getWithdrawAddresses method
$withdrawAddresses = $ariomex->wallet->getWithdrawAddresses();
```

### Bank

```php
// Example usage of the setBankCard method
$setCardResponse = $ariomex->bank->setBankCard('1234567890123456');

// Example usage of the setBankIban method
$setIbanResponse = $ariomex->bank->setBankIban('123456789012345678901234');

// Example usage of the getBankAccounts method
$bankAccounts = $ariomex->bank->getBankAccounts();
```

### History

```php
// Example usage of the getIrtDeposits method
$irtDeposits = $ariomex->history->getIrtDeposits('1715719124700', '1715719124700', 'completed', '1', '50');

// Example usage of the getCryptoDeposits method
$cryptoDeposits = $ariomex->history->getCryptoDeposits('btc', 'btc', '1715719124700', '1715719124700', 'completed', '1', '50');

// Example usage of the getIrtWithdrawals method
$irtWithdrawals = $ariomex->history->getIrtWithdrawals('1715719124700', '1715719124700', 'completed', '1', '50');

// Example usage of the getCryptoWithdrawals method
$cryptoWithdrawals = $ariomex->history->getCryptoWithdrawals('btc', 'btc', '1715719124700', '1715719124700', 'completed', '1', '50');

// Example usage of the getOrders method
$orders = $ariomex->history->getOrders('btcusdt', '', '1715719124700', '1715719124700', 'limit', 'buy', 'completed', '1', '50');

// Example usage of the getTrades method
$trades = $ariomex->history->getTrades('btcusdt', '1715719124700', '1715719124700', 'buy', '1', '50');
```

### Order

```php
// Example usage of the setLimitBuy method
$limitBuyOrder = $ariomex->order->setLimitBuy('btcusdt', '10000', '0.1');

// Example usage of the setLimitSell method
$limitSellOrder = $ariomex->order->setLimitSell('btcusdt', '11000', '0.1');

// Example usage of the setMarketBuy method
$marketBuyOrder = $ariomex->order->setMarketBuy('btcusdt', '1000');

// Example usage of the setMarketSell method
$marketSellOrder = $ariomex->order->setMarketSell('btcusdt', '0.1');

// Example usage of the setSLTP method
$sltpOrder = $ariomex->order->setSLTP('btcusdt', '0.1', '9000', '12000');

// Example usage of the setSL method
$slOrder = $ariomex->order->setSL('btcusdt', '0.1', '9000');

// Example usage of the setStoplimitBuy method
$stoplimitBuyOrder = $ariomex->order->setStoplimitBuy('btcusdt', '0.1', '9500', '9600');

// Example usage of the setStoplimitSell method
$stoplimitSellOrder = $ariomex->order->setStoplimitSell('btcusdt', '0.1', '10500', '10400');

// Example usage of the cancelOrder method
$cancelOrderResponse = $ariomex->order->cancelOrder('btcusdt', 'order_uuid_here');

// Example usage of the cancelAllOrders method
$cancelAllOrdersResponse = $ariomex->order->cancelAllOrders('btcusdt');
```
