<?php

namespace BelkinDom\Adapters\Web\View\MoneyFormatter;

use BelkinDom\Store\Money\Money;

interface MoneyFormatterInterface
{
    /**
     * @param Money $money
     *
     * @return string
     */
    public function format(Money $money): string;

    /**
     * @return string
     */
    public function getIsoCode(): string;
}
