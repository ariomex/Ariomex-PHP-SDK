<?php
/* 
 * --------------------------------------------------------------------
 * Include Ariomex API SDK and Create Instance
 * --------------------------------------------------------------------
 */
// Include the Ariomex API SDK class
require_once 'ariomex.php';
// Create an instance of the Ariomex class
$ariomex = new Ariomex('your_api_key', 'your_api_secret');
/* 
 * --------------------------------------------------------------------
 * General API Methods
 * --------------------------------------------------------------------
 */
// Example usage of the swagger method
$swagger = $ariomex->general->swagger();
echo "Swagger Documentation:\n";
echo $swagger . "\n";
// // Example usage of the ping method
// $pingResponse = $ariomex->general->ping();
// echo "Ping Response:\n";
// echo $pingResponse . "\n";
// // Example usage of the time method
// $serverTime = $ariomex->general->time();
// echo "Server Time:\n";
// echo $serverTime . "\n";
// // Example usage of the exchange_info method
// $exchangeInfo = $ariomex->general->exchange_info('btcusdt');
// echo "Exchange Info:\n";
// echo $exchangeInfo . "\n";
// // Example usage of the coins_info method
// $coinsInfo = $ariomex->general->coins_info('btc');
// echo "Coins Info:\n";
// echo $coinsInfo . "\n";
// // Example usage of the orderbook method
// $orderBook = $ariomex->general->orderbook('btcusdt');
// echo "Order Book:\n";
// echo $orderBook . "\n";
// // Example usage of the last_trades method
// $lastTrades = $ariomex->general->last_trades('btcusdt');
// echo "Last Trades:\n";
// echo $lastTrades . "\n";
// // Example usage of the last_prices method
// $lastPrices = $ariomex->general->last_prices('btcusdt');
// echo "Last Prices:\n";
// echo $lastPrices . "\n";
// // Example usage of the candlesticks method
// $candlesticks = $ariomex->general->candlesticks('btcusdt', '5');
// echo "Candlestick Data:\n";
// echo $candlesticks . "\n";
// /* 
//  * --------------------------------------------------------------------
//  * Account API Methods
//  * --------------------------------------------------------------------
//  */
// // Example usage of the getAccountInfo method
// $accountInfo = $ariomex->account->getAccountInfo();
// echo "Account Information:\n";
// echo $accountInfo . "\n";
// // Example usage of the getBalance method
// $balance = $ariomex->account->getBalance();
// echo "Account Balance:\n";
// echo $balance . "\n";
// // Example usage of the getDustBalance method
// $dustBalance = $ariomex->account->getDustBalance();
// echo "Dust Balance:\n";
// echo $dustBalance . "\n";
// // Example usage of the convertDustBalance method
// $conversionResult = $ariomex->account->convertDustBalance(['btc', 'eth']);
// echo "Conversion Result:\n";
// echo $conversionResult . "\n";
// /* 
//  * --------------------------------------------------------------------
//  * Wallet API Methods
//  * --------------------------------------------------------------------
//  */
// // Example usage of the generateDepositAddress method
// $depositAddress = $ariomex->wallet->generateDepositAddress();
// echo "Generated Deposit Address:\n";
// echo $depositAddress . "\n";
// // Example usage of the getDepositAddress method
// $depositAddress = $ariomex->wallet->getDepositAddress();
// echo "Deposit Address:\n";
// echo $depositAddress . "\n";
// // Example usage of the withdrawIrt method
// $withdrawalResponse = $ariomex->wallet->withdrawIrt('100', 'iban_uuid_here');
// echo "Withdrawal Response:\n";
// echo $withdrawalResponse . "\n";
// // Example usage of the withdrawCrypto method
// $withdrawalResponse = $ariomex->wallet->withdrawCrypto('btc', 'btc', '1', 'address_uuid_here', 'optional_memo');
// echo "Withdrawal Response:\n";
// echo $withdrawalResponse . "\n";
// // Example usage of the getWithdrawAddresses method
// $withdrawAddresses = $ariomex->wallet->getWithdrawAddresses();
// echo "Withdrawal Addresses:\n";
// echo $withdrawAddresses . "\n";
// /* 
//  * --------------------------------------------------------------------
//  * Bank API Methods
//  * --------------------------------------------------------------------
//  */
// // Example usage of the setBankCard method
// $setCardResponse = $ariomex->bank->setBankCard('1234567890123456');
// echo "Set Bank Card Response:\n";
// echo $setCardResponse . "\n";
// // Example usage of the setBankIban method
// $setIbanResponse = $ariomex->bank->setBankIban('123456789012345678901234');
// echo "Set Bank IBAN Response:\n";
// echo $setIbanResponse . "\n";
// // Example usage of the getBankAccounts method
// $bankAccounts = $ariomex->bank->getBankAccounts();
// echo "Bank Accounts:\n";
// echo $bankAccounts . "\n";
// /* 
//  * --------------------------------------------------------------------
//  * History API Methods
//  * --------------------------------------------------------------------
//  */
// // Example usage of the getIrtDeposits method
// $irtDeposits = $ariomex->history->getIrtDeposits('1715719124700', '1715719124700', 'completed', '1', '50');
// echo "IRT Deposits History:\n";
// echo $irtDeposits . "\n";
// // Example usage of the getCryptoDeposits method
// $cryptoDeposits = $ariomex->history->getCryptoDeposits('btc', 'btc', '1715719124700', '1715719124700', 'completed', '1', '50');
// echo "Crypto Deposits History:\n";
// echo $cryptoDeposits . "\n";
// // Example usage of the getIrtWithdrawals method
// $irtWithdrawals = $ariomex->history->getIrtWithdrawals('1715719124700', '1715719124700', 'completed', '1', '50');
// echo "IRT Withdrawals History:\n";
// echo $irtWithdrawals . "\n";
// // Example usage of the getCryptoWithdrawals method
// $cryptoWithdrawals = $ariomex->history->getCryptoWithdrawals('btc', 'btc', '1715719124700', '1715719124700', 'completed', '1', '50');
// echo "Crypto Withdrawals History:\n";
// echo $cryptoWithdrawals . "\n";
// // Example usage of the getOrders method
// $orders = $ariomex->history->getOrders('btcusdt', '1715719124700', '1715719124700', 'limit', 'buy', 'completed', '1', '50');
// echo "Orders History:\n";
// echo $orders . "\n";
// // Example usage of the getTrades method
// $trades = $ariomex->history->getTrades('btcusdt', '1715719124700', '1715719124700', 'buy', '1', '50');
// echo "Trades History:\n";
// echo $trades . "\n";
// /* 
//  * --------------------------------------------------------------------
//  * Order API Methods
//  * --------------------------------------------------------------------
//  */
// // Example usage of the setLimitBuy method
// $limitBuyOrder = $ariomex->order->setLimitBuy('btcusdt', '10000', '0.1');
// echo "Limit Buy Order Response:\n";
// echo $limitBuyOrder . "\n";
// // Example usage of the setLimitSell method
// $limitSellOrder = $ariomex->order->setLimitSell('btcusdt', '11000', '0.1');
// echo "Limit Sell Order Response:\n";
// echo $limitSellOrder . "\n";
// // Example usage of the setMarketBuy method
// $marketBuyOrder = $ariomex->order->setMarketBuy('btcusdt', '1000');
// echo "Market Buy Order Response:\n";
// echo $marketBuyOrder . "\n";
// // Example usage of the setMarketSell method
// $marketSellOrder = $ariomex->order->setMarketSell('btcusdt', '0.1');
// echo "Market Sell Order Response:\n";
// echo $marketSellOrder . "\n";
// // Example usage of the setSLTP method
// $sltpOrder = $ariomex->order->setSLTP('btcusdt', '0.1', '9000', '12000');
// echo "SLTP Order Response:\n";
// echo $sltpOrder . "\n";
// // Example usage of the setSL method
// $slOrder = $ariomex->order->setSL('btcusdt', '0.1', '9000');
// echo "SL Order Response:\n";
// echo $slOrder . "\n";
// // Example usage of the setStoplimitBuy method
// $stoplimitBuyOrder = $ariomex->order->setStoplimitBuy('btcusdt', '0.1', '9500', '9600');
// echo "Stop-limit Buy Order Response:\n";
// echo $stoplimitBuyOrder . "\n";
// // Example usage of the setStoplimitSell method
// $stoplimitSellOrder = $ariomex->order->setStoplimitSell('btcusdt', '0.1', '10500', '10400');
// echo "Stop-limit Sell Order Response:\n";
// echo $stoplimitSellOrder . "\n";
// // Example usage of the cancelOrder method
// $cancelOrderResponse = $ariomex->order->cancelOrder('btcusdt', 'order_uuid_here');
// echo "Cancel Order Response:\n";
// echo $cancelOrderResponse . "\n";
// // Example usage of the cancelAllOrders method
// $cancelAllOrdersResponse = $ariomex->order->cancelAllOrders('btcusdt');
// echo "Cancel All Orders Response:\n";
// echo $cancelAllOrdersResponse . "\n";
