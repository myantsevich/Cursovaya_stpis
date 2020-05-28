<?php

namespace BelkinDom\Store\Review;

use BelkinDom\Store\Common\TranslatableContent;

class Review
{
    /**
     * @var ReviewUuid
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

    public function __construct(ReviewUuid $reviewUuid, TranslatableContent $authorName, TranslatableContent $body)
    {
        $this->reviewUuid = $reviewUuid;
        $this->authorName = $authorName;
        $this->body = $body;
    }

    public static function generated(TranslatableContent $authorName, TranslatableContent $body): Review
    {
        return new self(ReviewUuid::generated(), $authorName, $body);
    }

    /**
     * @return ReviewUuid
     */
    public function reviewUuid(): ReviewUuid
    {
        return $this->reviewUuid;
    }

    /**
     * @return TranslatableContent
     */
    public function authorName(): TranslatableContent
    {
        return clone $this->authorName;
    }

    /**
     * @return TranslatableContent
     */
    public function body(): TranslatableContent
    {
        return clone $this->body;
    }
}
