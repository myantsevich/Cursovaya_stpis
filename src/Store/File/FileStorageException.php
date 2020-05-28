<?php

namespace BelkinDom\Store\File;

use RuntimeException;
use BelkinDom\Store\Exception;

class FileStorageException extends RuntimeException implements Exception
{
    public function __construct(string$message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
