<?php

namespace BelkinDom\Store\Cart;

use BelkinDom\Store\Money\Money;
use BelkinDom\Store\User\User;

class Cart
{
    /**
     * @var CartUuid
     */
    private $cartUuid;
    
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var CartItem[]
     */
    private $cartItems;

    public function __construct(CartUuid $cartUuid, User $user = null, array $cartItems = [])
    {
        $this->cartUuid = $cartUuid;
        $this->user = $user;
        $this->cartItems = $cartItems;
    }

    public static function generated(User $user = null, array $cartItems = [])
    {
        return new self(CartUuid::generated(), $user, $cartItems);
    }

    /**
     * @return CartUuid
     */
    public function cartUuid(): CartUuid
    {
        return $this->cartUuid;
    }
    
    /**
     * @return User|null
     */
    public function user(): ?User
    {
        return $this->user;
    }

    /**
     * @return CartItem[]
     */
    public function cartItems(): array
    {
        return $this->cartItems;
    }

    /**
     * @param CartItem $cartItem
     */
    public function addCartItem(CartItem $cartItem)
    {
        $this->cartItems[] = $cartItem;
    }

    /**
     * @param CartItem $cartItemToRemove
     */
    public function removeCartItem(CartItem $cartItemToRemove)
    {
        $this->cartItems = array_filter($this->cartItems, function ($cartItem) use ($cartItemToRemove) {
            return $cartItem !== $cartItemToRemove;
        });
    }

    /**
     * Clear cart from products
     */
    public function reset()
    {
        $this->cartItems = [];
    }

    /**
     * @return int
     */
    public function totalProductsQuantity(): int
    {
        return array_reduce($this->cartItems, function ($totalQty, CartItem $item) {
            $totalQty += $item->quantity();

            return $totalQty;
        }, 0);
    }

    /**
     * @return Money|null
     */
    public function totalPrice(): ?Money
    {
        $total = null;

        foreach ($this->cartItems() as $cartItem) {
            if (!$total) {
                $total = new Money(0, $cartItem->price()->currency());
            }

            $total = $total->increaseAmountBy($cartItem->price()->amount());
        }

        return $total;
    }
}
