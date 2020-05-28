<?php

namespace BelkinDom\Store\Review;

use RuntimeException;
use BelkinDom\Store\Exception;

class ReviewNotFoundException extends RuntimeException implements Exception
{
    public function __construct(ReviewUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Review "%s" not found.', $uuid), 0, $previous);
    }
}
