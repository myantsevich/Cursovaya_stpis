<?php

namespace BelkinDom\UseCase\Review;

use BelkinDom\Store\Review\Review;
use BelkinDom\Store\Review\Reviews;

class UpdateReviewUseCase
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
     * @param Review $updatedReview
     */
    public function execute(Review $review, Review $updatedReview)
    {
        $review = new Review(
            $updatedReview->reviewUuid(),
            $updatedReview->authorName(),
            $updatedReview->body()
        );

        $this->reviews->update($review);
    }
}
