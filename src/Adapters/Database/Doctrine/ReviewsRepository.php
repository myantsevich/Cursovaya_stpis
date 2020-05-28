<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Review\Reviews;
use BelkinDom\Store\Review\Review;
use BelkinDom\Store\Review\ReviewNotFoundException;
use BelkinDom\Store\Review\ReviewUuid;
use Pagerfanta\Pagerfanta;

final class ReviewsRepository extends EntityRepository implements Reviews
{
    /**
     * @param ReviewUuid $uuid
     *
     * @return Review
     *
     * @throws ReviewNotFoundException
     */
    public function get(ReviewUuid $uuid): Review
    {
        $review = $this->find((string) $uuid);

        if (!$review instanceof Review) {
            throw new ReviewNotFoundException($uuid);
        }

        return $review;
    }

    /**
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function list(Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('review');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param Review $review
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Review $review)
    {
        $this->getEntityManager()->persist($review);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Review $review
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Review $review)
    {
        $this->getEntityManager()->merge($review);
        $this->getEntityManager()->flush();
    }
}
