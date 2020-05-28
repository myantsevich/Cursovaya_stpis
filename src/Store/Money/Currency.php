<?php

namespace BelkinDom\Store\Money;

class Currency
{
    const USD_ISO_CODE = 'USD';
    const BYN_ISO_CODE = 'BYN';
    const AVAILABLE_ISO_CODES = [self::USD_ISO_CODE];

    /**
     * @var string
     */
    private $isoCode;

    public function __construct(string $isoCode)
    {
        if (!in_array($isoCode, self::AVAILABLE_ISO_CODES)) {
            throw new CurrencyNotFoundException($isoCode);
        }

        $this->isoCode = $isoCode;
    }

    /**
     * @return string
     */
    public function isoCode(): string
    {
        return $this->isoCode;
    }
}
