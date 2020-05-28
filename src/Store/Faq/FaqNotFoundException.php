<?php

namespace BelkinDom\Store\Faq;

use RuntimeException;
use BelkinDom\Store\Exception;

class FaqNotFoundException extends RuntimeException implements Exception
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct("Faq not found", 0, $previous);
    }
}
