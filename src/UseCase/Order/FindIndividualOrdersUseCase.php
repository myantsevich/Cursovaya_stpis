<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Order\IndividualOrder;
use BelkinDom\Store\Order\IndividualOrders;
use Pagerfanta\Pagerfanta;

class FindIndividualOrdersUseCase
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
     * @param Find $findRequest
     *
     * @return IndividualOrder[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->orders->list($findRequest);
    }
}
