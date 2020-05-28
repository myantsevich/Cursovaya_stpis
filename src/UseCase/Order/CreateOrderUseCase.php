<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\Order;
use BelkinDom\Store\Order\Orders;

class CreateOrderUseCase
{
    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var CreateOrderItemUseCase
     */
    private $createOrderItemUseCase;

    public function __construct(Orders $orders, CreateOrderItemUseCase $createOrderItemUseCase)
    {
        $this->orders = $orders;
        $this->createOrderItemUseCase = $createOrderItemUseCase;
    }

    /**
     * @param Order $order
     */
    public function execute(Order $order)
    {
        foreach ($order->orderItems() as $orderItem) {
            $this->createOrderItemUseCase->execute($orderItem);
        }

        return $this->orders->save($order);
    }
}
