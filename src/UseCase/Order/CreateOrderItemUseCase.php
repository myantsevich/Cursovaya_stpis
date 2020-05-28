<?php

namespace BelkinDom\UseCase\Order;

use BelkinDom\Store\Order\OrderItem;
use BelkinDom\Store\Order\OrderItems;
use BelkinDom\UseCase\Product\GetProductUseCase;

class CreateOrderItemUseCase
{
    /**
     * @var OrderItems
     */
    private $orderItems;

    /**
     * @var GetProductUseCase
     */
    private $getProductUseCase;

    public function __construct(OrderItems $orderItems, GetProductUseCase $getProductUseCase)
    {
        $this->orderItems = $orderItems;
        $this->getProductUseCase = $getProductUseCase;
    }

    /**
     * @param OrderItem $orderItem
     */
    public function execute(OrderItem $orderItem)
    {
        $product = $this->getProductUseCase->execute($orderItem->product()->productUuid());
        $orderItem->updateProduct($product);
        $this->orderItems->save($orderItem);
    }
}
