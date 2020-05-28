<?php

namespace BelkinDom\DTO\Blog;

use BelkinDom\Store\Common\TranslatableContent;

class Post
{
    /**
     * @var string|null
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

    private $previewImage;

    public function __construct()
    {
        $this->header = new TranslatableContent();
        $this->summary = new TranslatableContent();
        $this->content = new TranslatableContent();
    }

    /**
     * @return null|string
     */
    public function getPostUuid(): ?string
    {
        return $this->postUuid;
    }

    /**
     * @param null|string $postUuid
     */
    public function setPostUuid(?string $postUuid): void
    {
        $this->postUuid = $postUuid;
    }

    /**
     * @return TranslatableContent
     */
    public function getHeader(): TranslatableContent
    {
        return $this->header;
    }

    /**
     * @param TranslatableContent $header
     */
    public function setHeader(TranslatableContent $header): void
    {
        $this->header = $header;
    }

    /**
     * @return TranslatableContent
     */
    public function getSummary(): TranslatableContent
    {
        return $this->summary;
    }

    /**
     * @param TranslatableContent $summary
     */
    public function setSummary(TranslatableContent $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return TranslatableContent
     */
    public function getContent(): TranslatableContent
    {
        return $this->content;
    }

    /**
     * @param TranslatableContent $content
     */
    public function setContent(TranslatableContent $content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPreviewImage()
    {
        return $this->previewImage;
    }

    /**
     * @param mixed $previewImage
     */
    public function setPreviewImage($previewImage): void
    {
        $this->previewImage = $previewImage;
    }
}
