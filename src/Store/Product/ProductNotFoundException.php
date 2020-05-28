<?php

namespace BelkinDom\Store\Product;

use RuntimeException;
use BelkinDom\Store\Exception;

class ProductNotFoundException extends RuntimeException implements Exception
{
    public function __construct(ProductUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Product "%s" not found.', $uuid), 0, $previous);
    }
}
