<?php

namespace BelkinDom\DTO\Review;

use BelkinDom\Store\Common\TranslatableContent;

class Review
{
    /**
     * @var string|null
     */
    private $reviewUuid;

    /**
     * @var TranslatableContent
     */
    private $authorName;

    /**
     * @var TranslatableContent
     */
    private $body;

    /**
     * Review constructor.
     */
    public function __construct()
    {
        $this->authorName = new TranslatableContent();
        $this->body = new TranslatableContent();
    }

    /**
     * @return null|string
     */
    public function getReviewUuid(): ?string
    {
        return $this->reviewUuid;
    }

    /**
     * @param null|string $reviewUuid
     */
    public function setReviewUuid(?string $reviewUuid): void
    {
        $this->reviewUuid = $reviewUuid;
    }

    /**
     * @return TranslatableContent
     */
    public function getAuthorName(): TranslatableContent
    {
        return $this->authorName;
    }

    /**
     * @param TranslatableContent $authorName
     */
    public function setAuthorName(TranslatableContent $authorName): void
    {
        $this->authorName = $authorName;
    }

    /**
     * @return TranslatableContent
     */
    public function getBody(): TranslatableContent
    {
        return clone $this->body;
    }

    /**
     * @param TranslatableContent $body
     */
    public function setBody(TranslatableContent $body): void
    {
        $this->body = $body;
    }
}
