<?php

namespace BelkinDom\Store\Cart;

use BelkinDom\Store\Exception;
use RuntimeException;

class CartNotFoundException extends RuntimeException implements Exception
{
    public function __construct(CartUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Cart "%s" not found.', $uuid), 0, $previous);
    }
}
