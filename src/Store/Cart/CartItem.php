<?php

namespace BelkinDom\Store\Cart;

use BelkinDom\Store\Money\Money;
use BelkinDom\Store\Product\AbstractProduct;

class CartItem
{
    /**
     * @var CartItemUuid
     */
    private $cartItemUuid;

    /**
     * @var AbstractProduct
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(CartItemUuid $cartItemUuid, AbstractProduct $product, int $quantity = 1)
    {
        $this->cartItemUuid = $cartItemUuid;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function generated(AbstractProduct $product, int $quantity = 1)
    {
        return new self(CartItemUuid::generated(), $product, $quantity);
    }

    /**
     * @return CartItemUuid
     */
    public function cartItemUuid(): CartItemUuid
    {
        return $this->cartItemUuid;
    }

    /**
     * @return AbstractProduct
     */
    public function product(): AbstractProduct
    {
        return $this->product;
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

    public function increaseQuantity()
    {
        $this->quantity += 1;
    }
}
