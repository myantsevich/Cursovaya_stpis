<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\Order;
use BelkinDom\Store\Order\OrderNotFoundException;
use BelkinDom\Store\Order\Orders;
use BelkinDom\Store\Order\OrderUuid;

class GetOrderUseCase
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
     * @param OrderUuid $orderUuid
     *
     * @return Order
     *
     * @throws OrderNotFoundException
     */
    public function execute(OrderUuid $orderUuid): Order
    {
        return $this->orders->get($orderUuid);
    }
}
