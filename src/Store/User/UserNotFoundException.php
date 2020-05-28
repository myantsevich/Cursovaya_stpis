<?php

namespace BelkinDom\Store\User;

use BelkinDom\Store\Exception;
use RuntimeException;

class UserNotFoundException extends RuntimeException implements Exception
{
    public function __construct(string $id, \Exception $previous = null)
    {
        parent::__construct(sprintf('User "%s" not found.', $id), 0, $previous);
    }
}
