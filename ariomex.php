<?php

/**
 * Class Ariomex
 * 
 * Ariomex API SDK for interacting with the Ariomex API.
 */
class Ariomex
{
    private string $apiKey;     // API Key
    private string $apiSecret;  // API Secret
    private string $apiUrl;     // API base URL
    private string $signature;  // API request signature
    public  General $general;   // Instance of General class for accessing general API endpoints
    public  Account $account;   // Instance of General class for accessing general API endpoints
    public  Wallet $wallet;     // Instance of General class for accessing general API endpoints
    public  Bank $bank;         // Instance of General class for accessing general API endpoints
    public  History $history;   // Instance of General class for accessing general API endpoints
    public  Order $order;       // Instance of General class for accessing general API endpoints
    /**
     * Constructor.
     * 
     * @param string $apiKey    API Key.
     * @param string $apiSecret API Secret.
     */
    public function __construct(string $apiKey = '', string $apiSecret = '')
    {
        $this->apiKey    = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->apiUrl    = 'https://api.ariomex.com';
        $this->general   = new General($this);
        $this->account   = new Account($this);
        $this->wallet    = new Wallet($this);
        $this->bank      = new Bank($this);
        $this->history   = new History($this);
        $this->order     = new Order($this);
    }
    /**
     * Signs and sends the API request.
     * 
     * @param string $url              API endpoint URL.
     * @param array  $query            Query parameters.
     * @param string $method           HTTP method (GET, POST, etc.).
     * @param bool   $isPrivateEndpoint Whether the endpoint requires authentication.
     * 
     * @return string API response.
     */
    public function signAndSend(string $url, array $query, string $method, bool $isPrivateEndpoint): string
    {
        if ($isPrivateEndpoint) {
            $query['timestamp'] = strval(round(microtime(true) * 1000));
            $queryParameters    = http_build_query($query);
            $this->signature    = hash_hmac('sha256', $queryParameters, $this->apiSecret);
        }
        $fullUrl = "{$this->apiUrl}{$url}";
        if (!in_array($method, ['GET', 'DELETE'])) {
            $requestData = json_encode($query);
        } else {
            $fullUrl     .= '?' . http_build_query($query);
            $requestData  = null;
        }
        return $this->sendRequest($fullUrl, $method, $isPrivateEndpoint, $requestData);
    }
    /**
     * Sends HTTP request to the API.
     * 
     * @param string      $url           API endpoint URL.
     * @param string      $method        HTTP method (GET, POST, etc.).
     * @param bool        $isPrivateEndpoint Whether the endpoint requires authentication.
     * @param string|null $requestData   Optional request data for POST requests.
     * 
     * @return string API response.
     */
    private function sendRequest(string $url, string $method, bool $isPrivateEndpoint, ?string $requestData): string
    {
        $headers = ["Content-Type: application/json"];
        if ($isPrivateEndpoint) {
            $headers[] = "X-ARX-APIKEY: {$this->apiKey}";
            $headers[] = "X-ARX-SIGNATURE: {$this->signature}";
        }
        $curlOptions = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers,
        ];
        if ($requestData !== null) {
            $curlOptions[CURLOPT_POSTFIELDS] = $requestData;
        }
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
/**
 * Class General
 * 
 * General API endpoints for Ariomex.
 */
class General
{
    private Ariomex $parent;  // Parent Ariomex SDK instance
    /**
     * Constructor.
     * 
     * @param Ariomex $parent Parent Ariomex SDK instance.
     */
    public function __construct(Ariomex $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Retrieves API Swagger documentation.
     * 
     * @return string API Swagger documentation.
     */
    public function swagger(): string
    {
        $url               = '/v1/public/swagger';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Pings the API server.
     * 
     * @return string API server response.
     */
    public function ping(): string
    {
        $url               = '/v1/public/ping';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves server time from the API.
     * 
     * @return string Server time from the API.
     */
    public function time(): string
    {
        $url               = '/v1/public/time';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves exchange information.
     * 
     * @param string|null $symbol Symbol of the exchange.
     * 
     * @return string Exchange information.
     */
    public function exchange_info(?string $symbol = null): string
    {
        $url               = '/v1/public/exchange_info';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        if ($symbol !== null) {
            $query['symbol'] = $symbol;
        }
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves coins information.
     * 
     * @param string|null $symbol Symbol of the coins.
     * 
     * @return string Coins information.
     */
    public function coins_info(?string $symbol = null): string
    {
        $url               = '/v1/public/coins_info';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        if ($symbol !== null) {
            $query['symbol'] = $symbol;
        }
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves order book.
     * 
     * @param string|null $symbol Symbol of the order book.
     * 
     * @return string Order book information.
     */
    public function orderbook(?string $symbol = null): string
    {
        $url               = '/v1/public/orderbook';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        if ($symbol !== null) {
            $query['symbol'] = $symbol;
        }
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves last trades.
     * 
     * @param string|null $symbol Symbol of the last trades.
     * 
     * @return string Last trades information.
     */
    public function last_trades(?string $symbol = null): string
    {
        $url               = '/v1/public/last_trades';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        if ($symbol !== null) {
            $query['symbol'] = $symbol;
        }
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves last prices.
     * 
     * @param string|null $symbol Symbol of the last prices.
     * 
     * @return string Last prices information.
     */
    public function last_prices(?string $symbol = null): string
    {
        $url               = '/v1/public/last_prices';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = [];
        if ($symbol !== null) {
            $query['symbol'] = $symbol;
        }
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves candlestick data.
     * 
     * @param string      $symbol     Symbol of the candlesticks.
     * @param string      $resolution Resolution of the candlesticks.
     * @param string|null $from       Start time of the candlesticks data.
     * @param string|null $to         End time of the candlesticks data.
     * 
     * @return string Candlestick data.
     */
    public function candlesticks(string $symbol, string $resolution, ?string $from = null, ?string $to = null): string
    {
        $url               = '/v1/public/candlesticks';
        $isPrivateEndpoint = false;
        $method            = 'GET';
        $query             = ["symbol" => $symbol, "resolution" => $resolution];
        if ($from !== null) {
            $query['from'] = $from;
        }
        if ($to !== null) {
            $query['to'] = $to;
        }
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
}
/**
 * Class Account
 * 
 * Account API endpoints for Ariomex.
 */
class Account
{
    /**
     * The parent Ariomex object.
     *
     * @var Ariomex $parent
     */
    private Ariomex $parent;
    /**
     * Account constructor.
     *
     * @param Ariomex $parent The parent Ariomex object.
     */
    public function __construct(Ariomex $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Get account information.
     *
     * @return string Account information.
     */
    public function getAccountInfo(): string
    {
        $url               = '/v1/private/account/info';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Get account balance.
     *
     * @return string Account balance.
     */
    public function getBalance(): string
    {
        $url               = '/v1/private/account/get_balance';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Get dust balance.
     *
     * @return string Dust balance.
     */
    public function getDustBalance(): string
    {
        $url               = '/v1/private/account/get_dust_balance';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Convert dust balance for specified coins list.
     *
     * @param array $coinsList List of coins to convert dust balance.
     * 
     * @return string Conversion result.
     */
    public function convertDustBalance(array $coinsList): string
    {
        $url               = '/v1/private/account/convert_dust_balance';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'coinsList' => $coinsList
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
}
/**
 * Class Wallet
 * 
 * Wallet API endpoints for Ariomex.
 */
class Wallet
{
    /**
     * @var Ariomex The parent Ariomex instance.
     */
    private Ariomex $parent;
    /**
     * Constructor for Wallet class.
     *
     * @param Ariomex $parent The parent Ariomex instance.
     */
    public function __construct(Ariomex $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Generates a deposit address.
     *
     * @return string The generated deposit address.
     */
    public function generateDepositAddress(): string
    {
        $url               = '/v1/private/wallet/generate_deposit_address';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves the deposit address.
     *
     * @return string The deposit address.
     */
    public function getDepositAddress(): string
    {
        $url               = '/v1/private/wallet/get_deposit_address';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Withdraws IRT (Iranian Tooman Token).
     *
     * @param string $amount   The amount to withdraw.
     * @param string $ibanUuid The IBAN UUID.
     * @return string The withdrawal response.
     */
    public function withdrawIrt(string $amount, string $ibanUuid): string
    {
        $url               = '/v1/private/wallet/withdraw_irt';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            "amount"    => $amount,
            "iban_uuid" => $ibanUuid
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Withdraws cryptocurrency.
     *
     * @param string $symbol       The cryptocurrency symbol.
     * @param string $network      The network.
     * @param string $amount       The amount to withdraw.
     * @param string $address      The address .
     * @param string|null $memo    (Optional) Memo for the withdrawal.
     * @return string The withdrawal response.
     */
    public function withdrawCrypto(string $symbol, string $network, string $amount, string $address, ?string $memo = null): string
    {
        $url               = '/v1/private/wallet/withdraw_crypto';  // Corrected URL
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            "symbol"       => $symbol,
            "network"      => $network,
            "amount"       => $amount,
            "address" => $address,
            "memo"         => $memo
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves withdrawal addresses.
     *
     * @return string The withdrawal addresses.
     */
    public function getWithdrawAddresses(): string
    {
        $url               = '/v1/private/wallet/get_withdraw_address';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
}
/**
 * Class Bank
 * 
 * Bank API endpoints for Ariomex.
 */
class Bank
{
    /**
     * @var Ariomex The parent Ariomex instance.
     */
    private Ariomex $parent;
    /**
     * Constructor for Bank class.
     *
     * @param Ariomex $parent The parent Ariomex instance.
     */
    public function __construct(Ariomex $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Sets the bank card.
     *
     * @param string $cardNumber The bank card number.
     * @return string The response from the server.
     */
    public function setBankCard(string $cardNumber): string
    {
        $url               = '/v1/private/bank/set_card';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'cardNumber' => $cardNumber
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Sets the bank IBAN.
     *
     * @param string $iban The IBAN (without IR).
     * @return string The response from the server.
     */
    public function setBankIban(string $iban): string
    {
        $url               = '/v1/private/bank/set_iban';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'iban' => $iban
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves bank accounts.
     *
     * @return string The response from the server.
     */
    public function getBankAccounts(): string
    {
        $url               = '/v1/private/bank/get_accounts';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
}
/**
 * Class History
 * 
 * History API endpoints for Ariomex.
 */
class History
{
    private Ariomex $parent;
    /**
     * History constructor.
     * @param Ariomex $parent The parent object for API interaction.
     */
    public function __construct(Ariomex $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Retrieves IRT deposits history.
     * @param string|null $from Start date (optional).
     * @param string|null $to End date (optional).
     * @param string|null $status Deposit status (optional).
     * @param string|null $page Page number (optional).
     * @param string|null $maxRowsPerPage Maximum rows per page (optional).
     * @return string API response.
     */
    public function getIrtDeposits(?string $from = null, ?string $to = null, ?string $status = null, ?string $page = null, ?string $maxRowsPerPage = null): string
    {
        $url               = '/v1/private/history/deposit/irt';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [
            'from'           => $from,
            'to'             => $to,
            'status'         => $status,
            'page'           => $page,
            'maxRowsPerPage' => $maxRowsPerPage,
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves crypto deposits history.
     * @param string|null $symbol Crypto symbol (optional).
     * @param string|null $network Network (optional).
     * @param string|null $from Start date (optional).
     * @param string|null $to End date (optional).
     * @param string|null $status Deposit status (optional).
     * @param string|null $page Page number (optional).
     * @param string|null $maxRowsPerPage Maximum rows per page (optional).
     * @return string API response.
     */
    public function getCryptoDeposits(?string $symbol = null, ?string $network = null, ?string $from = null, ?string $to = null, ?string $status = null, ?string $page = null, ?string $maxRowsPerPage = null): string
    {
        $url               = '/v1/private/history/deposit/crypto';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [
            'symbol'         => $symbol,
            'network'        => $network,
            'from'           => $from,
            'to'             => $to,
            'status'         => $status,
            'page'           => $page,
            'maxRowsPerPage' => $maxRowsPerPage,
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves IRT withdrawals history.
     * @param string|null $from Start date (optional).
     * @param string|null $to End date (optional).
     * @param string|null $status Withdrawal status (optional).
     * @param string|null $page Page number (optional).
     * @param string|null $maxRowsPerPage Maximum rows per page (optional).
     * @return string API response.
     */
    public function getIrtWithdrawals(?string $from = null, ?string $to = null, ?string $status = null, ?string $page = null, ?string $maxRowsPerPage = null): string
    {
        $url               = '/v1/private/history/withdrawals/irt';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [
            'from'           => $from,
            'to'             => $to,
            'status'         => $status,
            'page'           => $page,
            'maxRowsPerPage' => $maxRowsPerPage,
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves crypto withdrawals history.
     * @param string|null $symbol Crypto symbol (optional).
     * @param string|null $network Network (optional).
     * @param string|null $from Start date (optional).
     * @param string|null $to End date (optional).
     * @param string|null $status Withdrawal status (optional).
     * @param string|null $page Page number (optional).
     * @param string|null $maxRowsPerPage Maximum rows per page (optional).
     * @return string API response.
     */
    public function getCryptoWithdrawals(?string $symbol = null, ?string $network = null, ?string $from = null, ?string $to = null, ?string $status = null, ?string $page = null, ?string $maxRowsPerPage = null): string
    {
        $url               = '/v1/private/history/withdrawals/crypto';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [
            'symbol'         => $symbol,
            'network'        => $network,
            'from'           => $from,
            'to'             => $to,
            'status'         => $status,
            'page'           => $page,
            'maxRowsPerPage' => $maxRowsPerPage,
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves order history.
     * @param string|null $symbol Trading symbol (optional).
     * @param string|null $from Start date (optional).
     * @param string|null $to End date (optional).
     * @param string|null $type Order type (optional).
     * @param string|null $side Order side (optional).
     * @param string|null $status Order status (optional).
     * @param string|null $page Page number (optional).
     * @param string|null $maxRowsPerPage Maximum rows per page (optional).
     * @return string API response.
     */
    public function getOrders(?string $symbol = null, ?string $orderId = null, ?string $from = null, ?string $to = null, ?string $type = null, ?string $side = null, ?string $status = null, ?string $page = null, ?string $maxRowsPerPage = null): string
    {
        $url               = '/v1/private/history/orders';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [
            'symbol'         => $symbol,
            'orderId'        => $orderId,
            'type'           => $type,
            'side'           => $side,
            'from'           => $from,
            'to'             => $to,
            'status'         => $status,
            'page'           => $page,
            'maxRowsPerPage' => $maxRowsPerPage,
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Retrieves trade history.
     * @param string|null $symbol Trading symbol (optional).
     * @param string|null $from Start date (optional).
     * @param string|null $to End date (optional).
     * @param string|null $side Trade side (optional).
     * @param string|null $page Page number (optional).
     * @param string|null $maxRowsPerPage Maximum rows per page (optional).
     * @return string API response.
     */
    public function getTrades(?string $symbol = null, ?string $from = null, ?string $to = null, ?string $side = null, ?string $page = null, ?string $maxRowsPerPage = null): string
    {
        $url               = '/v1/private/history/trades';
        $isPrivateEndpoint = true;
        $method            = 'GET';
        $query             = [
            'symbol'         => $symbol,
            'side'           => $side,
            'from'           => $from,
            'to'             => $to,
            'page'           => $page,
            'maxRowsPerPage' => $maxRowsPerPage,
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
}
/**
 * Class Order
 * 
 * Order API endpoints for Ariomex.
 */
class Order
{
    /**
     * @var Ariomex The parent Ariomex object.
     */
    private Ariomex $parent;
    /**
     * Order constructor.
     * @param Ariomex $parent The parent Ariomex object.
     */
    public function __construct(Ariomex $parent)
    {
        $this->parent = $parent;
    }
    /**
     * Places a limit buy order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $price The price per unit of the asset.
     * @param string $volume The volume of the asset to buy.
     * @return string The response from the API.
     */
    public function setLimitBuy(string $symbol, string $price, string $volume): string
    {
        $url               = '/v1/private/order/limit/buy';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol' => $symbol,
            'price'  => $price,
            'volume' => $volume
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a limit sell order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $price The price per unit of the asset.
     * @param string $volume The volume of the asset to sell.
     * @return string The response from the API.
     */
    public function setLimitSell(string $symbol, string $price, string $volume): string
    {
        $url               = '/v1/private/order/limit/sell';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol' => $symbol,
            'price'  => $price,
            'volume' => $volume
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a market buy order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $total The total cost of the assets to buy.
     * @return string The response from the API.
     */
    public function setMarketBuy(string $symbol, string $total): string
    {
        $url               = '/v1/private/order/market/buy';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol' => $symbol,
            'total'  => $total
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a market sell order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $volume The volume of the asset to sell.
     * @return string The response from the API.
     */
    public function setMarketSell(string $symbol, string $volume): string
    {
        $url               = '/v1/private/order/market/sell';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol' => $symbol,
            'volume' => $volume
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a stop-limit order with both stop-loss and take-profit prices.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $volume The volume of the asset.
     * @param string $slPrice The stop-loss price.
     * @param string $tpPrice The take-profit price.
     * @return string The response from the API.
     */
    public function setSLTP(string $symbol, string $volume, string $slPrice, string $tpPrice): string
    {
        $url               = '/v1/private/order/sltp/sl_tp';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol'   => $symbol,
            'volume'   => $volume,
            'sl_price' => $slPrice,
            'tp_price' => $tpPrice
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a stop-loss order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $volume The volume of the asset.
     * @param string $slPrice The stop-loss price.
     * @return string The response from the API.
     */
    public function setSL(string $symbol, string $volume, string $slPrice): string
    {
        $url               = '/v1/private/order/sltp/sl';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol'   => $symbol,
            'volume'   => $volume,
            'sl_price' => $slPrice
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a stop-limit buy order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $volume The volume of the asset.
     * @param string $price The price per unit of the asset.
     * @param string $stopPrice The stop price.
     * @return string The response from the API.
     */
    public function setStoplimitBuy(string $symbol, string $volume, string $price, string $stopPrice): string
    {
        $url               = '/v1/private/order/stoplimit/buy';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol' => $symbol,
            'volume' => $volume,
            'price'  => $price,
            'stop'   => $stopPrice
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Places a stop-limit sell order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $volume The volume of the asset.
     * @param string $price The price per unit of the asset.
     * @param string $stopPrice The stop price.
     * @return string The response from the API.
     */
    public function setStoplimitSell(string $symbol, string $volume, string $price, string $stopPrice): string
    {
        $url               = '/v1/private/order/stoplimit/sell';
        $isPrivateEndpoint = true;
        $method            = 'POST';
        $query             = [
            'symbol' => $symbol,
            'volume' => $volume,
            'price'  => $price,
            'stop'   => $stopPrice
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Cancels a specific order.
     *
     * @param string $symbol The symbol of the trading pair.
     * @param string $orderUuid The UUID of the order to cancel.
     * @return string The response from the API.
     */
    public function cancelOrder(string $symbol, string $orderUuid): string
    {
        $url               = '/v1/private/order/cancel';
        $isPrivateEndpoint = true;
        $method            = 'DELETE';
        $query             = [
            'symbol'     => $symbol,
            'order_uuid' => $orderUuid
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
    /**
     * Cancels all orders for a specific symbol.
     *
     * @param string|null $symbol The symbol of the trading pair (optional).
     * @return string The response from the API.
     */
    public function cancelAllOrders(string $symbol = null): string
    {
        $url               = '/v1/private/order/cancel_all';
        $isPrivateEndpoint = true;
        $method            = 'DELETE';
        $query             = [
            'symbol' => $symbol
        ];
        return $this->parent->signAndSend($url, $query, $method, $isPrivateEndpoint);
    }
}
