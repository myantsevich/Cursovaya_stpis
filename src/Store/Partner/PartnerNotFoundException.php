<?php

namespace BelkinDom\Store\Partner;

use RuntimeException;
use BelkinDom\Store\Exception;

class PartnerNotFoundException extends RuntimeException implements Exception
{
    public function __construct(PartnerUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Partner "%s" not found.', $uuid), 0, $previous);
    }
}
