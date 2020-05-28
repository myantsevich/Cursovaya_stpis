<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Order\Order;
use BelkinDom\Store\Order\Orders;
use Pagerfanta\Pagerfanta;

class FindOrdersUseCase
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
     * @param Find $findRequest
     *
     * @return Order[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->orders->list($findRequest);
    }
}
