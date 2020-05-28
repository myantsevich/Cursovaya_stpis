<?php

namespace BelkinDom\UseCase\Review;

use BelkinDom\Store\Review\Review;
use BelkinDom\Store\Review\Reviews;

class CreateReviewUseCase
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
     * @param Review $review
     */
    public function execute(Review $review)
    {
        $this->reviews->save($review);
    }
}
