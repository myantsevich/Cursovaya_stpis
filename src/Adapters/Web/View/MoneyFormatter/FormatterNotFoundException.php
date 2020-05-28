<?php

namespace BelkinDom\Adapters\Web\View\MoneyFormatter;

use Throwable;

class FormatterNotFoundException extends \RuntimeException
{
    public function __construct(string $isoCode, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Price formatter for currency %s not found', $isoCode), $code, $previous);
    }
}
