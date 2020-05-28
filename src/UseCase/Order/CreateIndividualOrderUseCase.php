<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\IndividualOrder;
use BelkinDom\Store\Order\IndividualOrders;

class CreateIndividualOrderUseCase
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
     */
    public function execute(IndividualOrder $order)
    {
        return $this->orders->save($order);
    }
}
