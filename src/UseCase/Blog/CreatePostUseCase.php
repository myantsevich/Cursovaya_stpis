<?php

namespace BelkinDom\UseCase\Blog;

use BelkinDom\Store\Blog\Post;
use BelkinDom\Store\Blog\Posts;
use BelkinDom\UseCase\File\CreateFileUseCase;

class CreatePostUseCase
{
    /**
     * @var Posts
     */
    private $posts;

    /**
     * @var CreateFileUseCase
     */
    private $createFileUseCase;

    public function __construct(Posts $posts, CreateFileUseCase $createFileUseCase)
    {
        $this->posts = $posts;
        $this->createFileUseCase = $createFileUseCase;
    }

    /**
     * @param Post $post
     */
    public function execute(Post $post)
    {
        $this->createFileUseCase->execute($post->previewImage());
        $this->posts->save($post);
    }
}
