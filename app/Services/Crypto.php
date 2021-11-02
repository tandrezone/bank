<?php

namespace App\Services;

use ccxt\binance;

class Crypto
{
    const KNOWN_SYMBOLS = [
        'UMA',
        'ZRX',
        'OMG',
        'ANKR',
        '1INCH',
        'ETH',
        'XRP',
        'ADA',
        'DOT',
        'BCH',
        'ENJ',
        'MATIC',
        'XLM',
        'ALGO',
        'CRV',
        'MANA',
        'LRC'
    ];
    const CONVERSION_RATE_SYMBOL = 'BTCEUR';

    private $exchange;
    private $conversionRate;

    public function __construct() {
        $this->exchange = new binance();
        $this->exchange->load_markets();
        $this->conversionRate = $this->getRate(self::CONVERSION_RATE_SYMBOL);

    }

    public function getRate($symbol, $convert = false) {
        $ticker = $this->exchange->fetch_ticker($symbol);
        if($convert == false) {
            return $ticker['last'];
        }
        return $ticker['last']*$this->conversionRate;
    }

}
