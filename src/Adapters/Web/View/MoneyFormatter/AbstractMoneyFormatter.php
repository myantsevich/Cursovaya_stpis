<?php

namespace BelkinDom\Adapters\Web\View\MoneyFormatter;

abstract class AbstractMoneyFormatter implements MoneyFormatterInterface
{
    /**
     * @var string
     */
    protected $isoCode;

    /**
     * @inheritdoc
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }
}
