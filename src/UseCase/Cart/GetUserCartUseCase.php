<?php

namespace BelkinDom\UseCase\Cart;

use BelkinDom\Store\Cart\Cart;
use BelkinDom\Store\Cart\CartNotFoundException;
use BelkinDom\Store\Cart\Carts;
use BelkinDom\Store\User\User;

class GetUserCartUseCase
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
     * @param User|null $user
     *
     * @return Cart
     */
    public function execute(User $user = null): Cart
    {
        try {
            $cart = $this->carts->getUserCart($user);
        } catch (CartNotFoundException $x) {
            $cart = Cart::generated($user);
            $this->carts->save($cart);
        }

        return $cart;
    }
}
