<?php

namespace BelkinDom\Store\Cart;

use BelkinDom\Store\Product\AbstractProduct;
use BelkinDom\Store\User\User;

interface Carts
{
    /**
     * @param User|null $user
     *
     * @return Cart
     */
    public function getUserCart(User $user = null): Cart;

    /**
     * @param CartUuid $uuid
     *
     * @throws CartNotFoundException
     *
     * @return Cart
     */
    public function get(CartUuid $uuid): Cart;

    /**
     * @param Cart $cart
     * @param AbstractProduct $product
     *
     * @return CartItem|null
     */
    public function getCartItemByProduct(Cart $cart, AbstractProduct $product): ?CartItem;

    /**
     * @param Cart $cart
     */
    public function save(Cart $cart);
}
