<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\IndividualOrder;
use BelkinDom\Store\Order\IndividualOrders;

class UpdateIndividualOrderUseCase
{
    /**
     * @var IndividualOrders
     */
    private $orders;

    public function __construct(IndividualOrders $orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param IndividualOrder $order
     * @param IndividualOrder $updatedOrder
     */
    public function execute(IndividualOrder $order, IndividualOrder $updatedOrder)
    {
        return $this->orders->update($order);
    }
}
