<?php

namespace BelkinDom\Store\Order;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface Orders
{
    /**
     * @param OrderUuid $uuid
     *
     * @throws OrderNotFoundException
     *
     * @return Order
     */
    public function get(OrderUuid $uuid): Order;


    /**
     * @param Find $find
     *
     * @return Order[]|Pagerfanta
     */
    public function list(Find $find): Pagerfanta;

    /**
     * @param Order $order
     */
    public function save(Order $order);

    /**
     * @param Order $order
     */
    public function update(Order $order);
}
