<?php

namespace BelkinDom\UseCase\Blog;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Blog\Post;
use BelkinDom\Store\Blog\Posts;
use Pagerfanta\Pagerfanta;

class FindPostsUseCase
{
    /**
     * @var Posts
     */
    private $posts;

    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @param Find $findRequest
     *
     * @return Post[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->posts->list($findRequest);
    }
}
