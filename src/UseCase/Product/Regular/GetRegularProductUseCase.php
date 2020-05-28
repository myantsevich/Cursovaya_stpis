<?php

namespace BelkinDom\UseCase\Product\Regular;

use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\Products;
use BelkinDom\Store\Product\ProductUuid;

class GetRegularProductUseCase
{
    /**
     * @var Products
     */
    private $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param ProductUuid $productUuid
     *
     * @return Product
     *
     * @throws ProductNotFoundException
     */
    public function execute(ProductUuid $productUuid): Product
    {
        return $this->products->get($productUuid);
    }
}
