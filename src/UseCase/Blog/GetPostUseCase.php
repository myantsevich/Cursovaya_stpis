<?php

namespace BelkinDom\UseCase\Blog;

use BelkinDom\Store\Blog\Post;
use BelkinDom\Store\Blog\PostNotFoundException;
use BelkinDom\Store\Blog\Posts;
use BelkinDom\Store\Blog\PostUuid;

class GetPostUseCase
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
     * @param PostUuid $postUuid
     *
     * @return Post
     *
     * @throws PostNotFoundException
     */
    public function execute(PostUuid $postUuid): Post
    {
        return $this->posts->get($postUuid);
    }
}
