<?php

namespace BelkinDom\Store\Contact;

use RuntimeException;
use BelkinDom\Store\Exception;

class ContactNotFoundException extends RuntimeException implements Exception
{
    public function __construct(ContactUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Contact "%s" not found.', $uuid), 0, $previous);
    }
}
