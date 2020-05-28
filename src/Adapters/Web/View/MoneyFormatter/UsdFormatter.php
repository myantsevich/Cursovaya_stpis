<?php

namespace BelkinDom\Adapters\Web\View\MoneyFormatter;

use BelkinDom\Store\Money\Currency;
use BelkinDom\Store\Money\Money;

class UsdFormatter extends AbstractMoneyFormatter
{
    const CURRENCY_CHAR = '$';

    public function __construct()
    {
        $this->isoCode = Currency::USD_ISO_CODE;
    }

    /**
     * @inheritdoc
     */
    public function format(Money $money): string
    {
        return sprintf('%s%d', self::CURRENCY_CHAR, $money->amount());
    }
}
