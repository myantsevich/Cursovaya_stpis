<?php

namespace BelkinDom\UseCase\Product;

use BelkinDom\DTO\Product\ProductsTotals;
use BelkinDom\Store\Product\Products;

class GetProductsTotalsByCategoryUseCase
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
     * @return ProductsTotals
     */
    public function execute(): ProductsTotals
    {
        return $this->products->getTotalsByCategory();
    }
}
