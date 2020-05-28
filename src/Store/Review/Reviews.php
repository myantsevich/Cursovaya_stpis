<?php

namespace BelkinDom\Store\Review;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface Reviews
{
    /**
     * @param ReviewUuid $uuid
     *
     * @throws ReviewNotFoundException
     *
     * @return Review
     */
    public function get(ReviewUuid $uuid): Review;

    /**
     * @param Find $findRequest
     *
     * @return Review[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param Review $review
     */
    public function save(Review $review);

    /**
     * @param Review $review
     */
    public function update(Review $review);
}
