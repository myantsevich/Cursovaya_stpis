<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Order\Orders;
use BelkinDom\Store\Order\Order;
use BelkinDom\Store\Order\OrderNotFoundException;
use BelkinDom\Store\Order\OrderUuid;
use Pagerfanta\Pagerfanta;

final class OrdersRepository extends EntityRepository implements Orders
{
    /**
     * @param OrderUuid $uuid
     *
     * @return Order
     *
     * @throws OrderNotFoundException
     */
    public function get(OrderUuid $uuid): Order
    {
        $order = $this->find((string) $uuid);

        if (!$order instanceof Order) {
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
        $qb = $this->createQueryBuilder('orders');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param Order $order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Order $order)
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Order $order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Order $order)
    {
        $this->getEntityManager()->merge($order);
        $this->getEntityManager()->flush();
    }
}
