<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Order\IndividualOrders;
use BelkinDom\Store\Order\IndividualOrder;
use BelkinDom\Store\Order\OrderNotFoundException;
use BelkinDom\Store\Order\OrderUuid;
use Pagerfanta\Pagerfanta;

final class IndividualOrdersRepository extends EntityRepository implements IndividualOrders
{
    /**
     * @param OrderUuid $uuid
     *
     * @return IndividualOrder
     *
     * @throws OrderNotFoundException
     */
    public function get(OrderUuid $uuid): IndividualOrder
    {
        $order = $this->find((string) $uuid);

        if (!$order instanceof IndividualOrder) {
            throw new OrderNotFoundException($uuid);
        }

        return $order;
    }

    /**
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function list(Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('individual_orders');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param IndividualOrder $order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(IndividualOrder $order)
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * @param IndividualOrder $order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(IndividualOrder $order)
    {
        $this->getEntityManager()->merge($order);
        $this->getEntityManager()->flush();
    }
}
