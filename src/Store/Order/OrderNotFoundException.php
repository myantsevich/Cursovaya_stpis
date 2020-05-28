<?php

namespace BelkinDom\Store\Order;

use RuntimeException;
use BelkinDom\Store\Exception;

class OrderNotFoundException extends RuntimeException implements Exception
{
    public function __construct(OrderUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Order "%s" not found.', $uuid), 0, $previous);
    }
}
