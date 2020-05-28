<?php

namespace BelkinDom\Store\Order;

use BelkinDom\Store\Money\Money;
use BelkinDom\Store\Product\AbstractProduct;

class OrderItem
{
    /**
     * @var OrderItemUuid
     */
    private $orderItemUuid;

    /**
     * @var AbstractProduct
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(OrderItemUuid $orderItemUuid, AbstractProduct $product, int $quantity = 1)
    {
        $this->orderItemUuid = $orderItemUuid;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function generated(AbstractProduct $product, int $quantity = 1)
    {
        return new self(OrderItemUuid::generated(), $product, $quantity);
    }

    /**
     * @return OrderItemUuid
     */
    public function orderItemUuid(): OrderItemUuid
    {
        return $this->orderItemUuid;
    }

    /**
     * @return AbstractProduct
     */
    public function product(): AbstractProduct
    {
        return $this->product;
    }

    /**
     * @param AbstractProduct $product
     */
    public function updateProduct(AbstractProduct $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function quantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return Money
     */
    public function price(): Money
    {
        return new Money(
            $this->product->priceAmount() * $this->quantity,
            $this->product()->price()->currency()
        );
    }
}
