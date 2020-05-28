<?php

namespace BelkinDom\UseCase\Review;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Review\Review;
use BelkinDom\Store\Review\Reviews;
use Pagerfanta\Pagerfanta;

class FindReviewsUseCase
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
     * @param Find $findRequest
     *
     * @return Review[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->reviews->list($findRequest);
    }
}
