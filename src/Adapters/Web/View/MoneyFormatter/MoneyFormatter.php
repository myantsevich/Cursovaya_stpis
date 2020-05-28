<?php

namespace BelkinDom\Adapters\Web\View\MoneyFormatter;

use BelkinDom\Store\Money\Money;

final class MoneyFormatter extends AbstractMoneyFormatter
{
    /**
     * @var MoneyFormatterInterface[]
     */
    private $formatters = [];

    /**
     * @inheritdoc
     *
     * @throws FormatterNotFoundException
     */
    public function format(Money $money): string
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->getIsoCode() === $money->currency()->isoCode()) {
                return $formatter->format($money);
            }
        }

        throw new FormatterNotFoundException($money->currency()->isoCode());
    }

    /**
     * @param MoneyFormatterInterface $formatter
     */
    public function addFormatter(MoneyFormatterInterface $formatter)
    {
        $this->formatters[] = $formatter;
    }
}
