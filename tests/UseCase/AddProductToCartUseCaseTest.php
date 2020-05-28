<?php

namespace BelkinDom\Tests\UseCase;

use BelkinDom\Store\Cart;
use BelkinDom\Store\CartItem;
use BelkinDom\Store\Products;
use BelkinDom\Store\Product;
use BelkinDom\Store\StoreUuid;
use BelkinDom\UseCase\AddProductToCartUseCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class AddProductToCartUseCaseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Cart|ObjectProphecy
     */
    private $cart;

    /**
     * @var Product|ObjectProphecy
     */
    private $product;

    /**
     * @var Products|ObjectProphecy
     */
    private $carts;

    /**
     * @var AddProductToCartUseCase
     */
    private $useCase;

    protected function setUp()
    {
        $this->cart = $this->prophesize(Cart::class);
        $this->product = $this->prophesize(Product::class);
        $this->carts = $this->prophesize(Products::class);
        $this->useCase = new AddProductToCartUseCase($this->carts->reveal());
    }

    /**
     * @test
     */
    public function addNewProductToCartTest()
    {
        $cartUuid = StoreUuid::generated();
        $this->carts->get($cartUuid)->willReturn($this->cart->reveal());
        $this->carts->getCartItemByProduct($this->cart, $this->product)->willReturn(null);
        $this->useCase->execute($cartUuid, $this->product->reveal());
        $this->cart->addCartItem(Argument::type(CartItem::class))->shouldHaveBeenCalled();
    }
}
