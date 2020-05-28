<?php

namespace BelkinDom\UseCase\Cart;

use BelkinDom\Store\Cart\Cart;
use BelkinDom\Store\Cart\Carts;
use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Product\GetProductUseCase;

class RemoveProductFromCartUseCase
{
    /**
     * @var Carts
     */
    private $carts;

    /**
     * @var GetProductUseCase
     */
    private $getProductUseCase;

    public function __construct(Carts $carts, GetProductUseCase $getProductUseCase)
    {
        $this->carts = $carts;
        $this->getProductUseCase = $getProductUseCase;
    }

    /**
     * @param ProductUuid $productUuid
     * @param Cart $cart
     */
    public function execute(ProductUuid $productUuid, Cart $cart)
    {
        $product = $this->getProductUseCase->execute($productUuid);
        $cartItem = $this->carts->getCartItemByProduct($cart, $product);

        if ($cartItem) {
            $cart->removeCartItem($cartItem);
        }

        $this->carts->save($cart);
    }
}
