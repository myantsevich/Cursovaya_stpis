<?php

namespace BelkinDom\Store\Product\Category;

use RuntimeException;
use BelkinDom\Store\Exception;

class CategoryNotFoundException extends RuntimeException implements Exception
{
    public function __construct(string $title, \Exception $previous = null)
    {
        parent::__construct(sprintf('Category "%s" not found.', $title), 0, $previous);
    }
}
