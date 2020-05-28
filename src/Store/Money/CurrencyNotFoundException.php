<?php

namespace BelkinDom\Store\Money;

use BelkinDom\Store\Exception;
use RuntimeException;

class CurrencyNotFoundException extends RuntimeException implements Exception
{
    public function __construct(string $isoCode, \Exception $previous = null)
    {
        parent::__construct(sprintf('Currency for iso code "%s" is not available.', $isoCode), 0, $previous);
    }
}
