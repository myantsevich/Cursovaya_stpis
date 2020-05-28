<?php

namespace BelkinDom\UseCase\Blog;

use BelkinDom\Store\Blog\Post;
use BelkinDom\Store\Blog\Posts;
use BelkinDom\UseCase\File\UpdateFileUseCase;

class UpdatePostUseCase
{
    /**
     * @var Posts
     */
    private $posts;

    /**
     * @var UpdateFileUseCase
     */
    private $updateFileUseCase;

    public function __construct(Posts $posts, UpdateFileUseCase $updateFileUseCase)
    {
        $this->posts = $posts;
        $this->updateFileUseCase = $updateFileUseCase;
    }

    /**
     * @param Post $post
     * @param Post $updatedPost
     */
    public function execute(Post $post, Post $updatedPost)
    {
        if (!$post->previewImage()->equalsTo($updatedPost->previewImage())) {
            $this->updateFileUseCase->execute($post->previewImage(), $updatedPost->previewImage());
        }

        $post = new Post(
            $updatedPost->postUuid(),
            $updatedPost->header(),
            $updatedPost->summary(),
            $updatedPost->content(),
            $updatedPost->previewImage()
        );

        $this->posts->update($post);
    }
}
