<?php

namespace BelkinDom\Adapters\Instagram\Exception;

use RuntimeException;

class InstagramAuthException extends RuntimeException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message ?? 'Instagram auth exception', 0, $previous);
    }
}
