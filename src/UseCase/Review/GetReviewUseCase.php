<?php

namespace BelkinDom\UseCase\Review;

use BelkinDom\Store\Review\Review;
use BelkinDom\Store\Review\ReviewNotFoundException;
use BelkinDom\Store\Review\Reviews;
use BelkinDom\Store\Review\ReviewUuid;

class GetReviewUseCase
{
    /**
     * @var Reviews
     */
    private $reviews;

    public function __construct(Reviews $reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * @param ReviewUuid $reviewUuid
     *
     * @return Review
     *
     * @throws ReviewNotFoundException
     */
    public function execute(ReviewUuid $reviewUuid): Review
    {
        return $this->reviews->get($reviewUuid);
    }
}
