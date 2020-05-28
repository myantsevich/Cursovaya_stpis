<?php

namespace BelkinDom\UseCase\Product\Regular;

use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\Products;
use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

class FindRegularProductsUseCase
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
     * @param Find $findRequest
     *
     * @return Product[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->products->list($findRequest);
    }
}
