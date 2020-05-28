<?php

namespace BelkinDom\UseCase\Product;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Product\Products;
use BelkinDom\Store\Product\RugStencilProducts;

class FindAllProductsUseCase
{
    /**
     * @var Products
     */
    private $regularProducts;

    /**
     * @var RugStencilProducts
     */
    private $rugStencilProducts;

    public function __construct(Products $products, RugStencilProducts $rugStencilProducts)
    {
        $this->regularProducts = $products;
        $this->rugStencilProducts = $rugStencilProducts;
    }

    /**
     * @param Find $findRequest
     *
     * @return array
     */
    public function execute(Find $findRequest): array
    {
        $regularProductsList = $this->regularProducts->list($findRequest);
        $rugStencilProductsList = $this->rugStencilProducts->list($findRequest);

        return array_merge(
            (array) $regularProductsList->getCurrentPageResults(),
            (array) $rugStencilProductsList->getCurrentPageResults()
        );
    }
}
