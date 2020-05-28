<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\Order;
use BelkinDom\Store\Order\Orders;

class UpdateOrderUseCase
{
    /**
     * @var Orders
     */
    private $orders;

    public function __construct(Orders $orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param Order $order
     * @param Order $updatedOrder
     */
    public function execute(Order $order, Order $updatedOrder)
    {
        return $this->orders->update($order);
    }
}
