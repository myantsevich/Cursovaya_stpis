<?php

namespace BelkinDom\Store\Web;

use BelkinDom\Store\Exception;
use RuntimeException;

class ConfigNotFoundException extends RuntimeException implements Exception
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct('Config not found.', 0, $previous);
    }
}
