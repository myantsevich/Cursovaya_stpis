<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\IndividualOrder;
use BelkinDom\Store\Order\OrderNotFoundException;
use BelkinDom\Store\Order\IndividualOrders;
use BelkinDom\Store\Order\OrderUuid;

class GetIndividualOrderUseCase
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
     * @param OrderUuid $orderUuid
     *
     * @return IndividualOrder
     *
     * @throws OrderNotFoundException
     */
    public function execute(OrderUuid $orderUuid): IndividualOrder
    {
        return $this->orders->get($orderUuid);
    }
}
