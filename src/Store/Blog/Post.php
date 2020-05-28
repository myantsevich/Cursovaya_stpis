<?php

namespace BelkinDom\Store\Blog;

use BelkinDom\Store\Common\TranslatableContent;
use BelkinDom\Store\File\File;

class Post
{
    /**
     * @var PostUuid
     */
    private $postUuid;

    /**
     * @var TranslatableContent
     */
    private $header;

    /**
     * @var TranslatableContent
     */
    private $summary;

    /**
     * @var TranslatableContent
     */
    private $content;

    /**
     * @var File
     */
    private $previewImage;

    public function __construct(
        PostUuid $postUuid,
        TranslatableContent $header,
        TranslatableContent $summary,
        TranslatableContent $content,
        File $previewImage
    ) {
        $this->postUuid = $postUuid;
        $this->header = $header;
        $this->summary = $summary;
        $this->content = $content;
        $this->previewImage = $previewImage;
    }

    public static function generated(
        TranslatableContent $header,
        TranslatableContent $summary,
        TranslatableContent $content,
        File $previewImage
    ): Post {
        return new self(PostUuid::generated(), $header, $summary, $content, $previewImage);
    }

    /**
     * @return PostUuid
     */
    public function postUuid(): PostUuid
    {
        return $this->postUuid;
    }

    /**
     * @return TranslatableContent
     */
    public function header(): TranslatableContent
    {
        return $this->header;
    }

    /**
     * @return TranslatableContent
     */
    public function summary(): TranslatableContent
    {
        return $this->summary;
    }

    /**
     * @return TranslatableContent
     */
    public function content(): TranslatableContent
    {
        return $this->content;
    }

    /**
     * @return File
     */
    public function previewImage(): File
    {
        return $this->previewImage;
    }
}
