<?php

namespace BelkinDom\Store\Order;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface IndividualOrders
{
    /**
     * @param Find $findRequest
     *
     * @return IndividualOrder[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param OrderUuid $orderUuid
     *
     * @return IndividualOrder
     *
     * @throws OrderNotFoundException
     */
    public function get(OrderUuid $orderUuid): IndividualOrder;

    /**
     * @param IndividualOrder $individualOrder
     */
    public function save(IndividualOrder $individualOrder);

    /**
     * @param IndividualOrder $individualOrder
     */
    public function update(IndividualOrder $individualOrder);
}
