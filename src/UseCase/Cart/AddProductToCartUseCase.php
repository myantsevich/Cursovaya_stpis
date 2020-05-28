<?php

namespace BelkinDom\UseCase\Cart;

use BelkinDom\Store\Cart\Cart;
use BelkinDom\Store\Cart\CartItem;
use BelkinDom\Store\Cart\Carts;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Product\GetProductUseCase;

class AddProductToCartUseCase
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
     *
     * @throws ProductNotFoundException
     */
    public function execute(ProductUuid $productUuid, Cart $cart)
    {
        $product = $this->getProductUseCase->execute($productUuid);
        $cartItem = $this->carts->getCartItemByProduct($cart, $product);

        if ($cartItem) {
            $cartItem->increaseQuantity();
        } else {
            $cart->addCartItem(CartItem::generated($product));
        }

        $this->carts->save($cart);
    }
}
