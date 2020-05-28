<?php

namespace BelkinDom\Store\Blog;

use RuntimeException;
use BelkinDom\Store\Exception;

class PostNotFoundException extends RuntimeException implements Exception
{
    public function __construct(PostUuid $uuid, \Exception $previous = null)
    {
        parent::__construct(sprintf('Post "%s" not found.', $uuid), 0, $previous);
    }
}
