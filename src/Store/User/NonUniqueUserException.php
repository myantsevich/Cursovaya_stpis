<?php

namespace BelkinDom\Store\User;

use BelkinDom\Store\Exception;
use RuntimeException;

class NonUniqueUserException extends RuntimeException implements Exception
{
    public function __construct(string $username, \Exception $previous = null)
    {
        parent::__construct(sprintf('User with username "%s" already exists.', $username), 0, $previous);
    }
}
