<?php

namespace BelkinDom\Store\Blog;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface Posts
{
    /**
     * @param PostUuid $uuid
     *
     * @throws PostNotFoundException
     *
     * @return Post
     */
    public function get(PostUuid $uuid): Post;

    /**
     * @param Find $findRequest
     *
     * @return Post[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param Post $post
     */
    public function save(Post $post);

    /**
     * @param Post $post
     */
    public function update(Post $post);
}
