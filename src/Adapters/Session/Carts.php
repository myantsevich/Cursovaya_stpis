<?php

namespace BelkinDom\Adapters\Session;

use BelkinDom\Store\Cart\Cart;
use BelkinDom\Store\Cart\CartItem;
use BelkinDom\Store\Cart\CartNotFoundException;
use BelkinDom\Store\Cart\Carts as CartsInterface;
use BelkinDom\Store\Cart\CartUuid;
use BelkinDom\Store\Product\AbstractProduct;
use BelkinDom\Store\User\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Carts implements CartsInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param User|null $user
     *
     * @return Cart
     */
    public function getUserCart(User $user = null): Cart
    {
        if (!$this->session->has('user_cart_id')) {
            throw new CartNotFoundException(CartUuid::existing(''));
        }

        $cartUuid = CartUuid::existing($this->session->get('user_cart_id'));

        return $this->get($cartUuid);
    }

    /**
     * @param CartUuid $uuid
     *
     * @throws CartNotFoundException
     *
     * @return Cart
     */
    public function get(CartUuid $uuid): Cart
    {
        return $this->session->get((string) $uuid);
    }

    /**
     * @param Cart $cart
     * @param AbstractProduct $product
     *
     * @return CartItem|null
     */
    public function getCartItemByProduct(Cart $cart, AbstractProduct $product): ?CartItem
    {
        $cart = $this->get($cart->cartUuid());
        $result = array_filter($cart->cartItems(), function (CartItem $cartItem) use ($product) {
            return $cartItem->product()->productUuid()->isEqual($product->productUuid());
        });

        if (is_array($result) && count($result) > 0) {
            return array_shift($result);
        }

        return null;
    }

    /**
     * @param Cart $cart
     */
    public function save(Cart $cart)
    {
        $this->session->set('user_cart_id', (string) $cart->cartUuid());
        $this->session->set((string) $cart->cartUuid(), $cart);
    }
}