<?php

namespace BelkinDom\UseCase\Cart;

use BelkinDom\Store\Cart\Cart;
use BelkinDom\Store\Cart\Carts;

class ResetCartUseCase
{
    /**
     * @var Carts
     */
    private $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    /**
     * @param Cart $cart
     */
    public function execute(Cart $cart)
    {
        $cart->reset();

        $this->carts->save($cart);
    }
}
