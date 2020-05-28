<?php

namespace BelkinDom\UseCase\Product\RugStencil;

use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\Store\Product\RugStencilProduct;
use BelkinDom\Store\Product\RugStencilProducts;

class GetRugStencilProductUseCase
{
    /**
     * @var RugStencilProducts
     */
    private $products;

    public function __construct(RugStencilProducts $products)
    {
        $this->products = $products;
    }

    /**
     * @param ProductUuid $productUuid
     *
     * @return RugStencilProduct
     *
     * @throws ProductNotFoundException
     */
    public function execute(ProductUuid $productUuid): RugStencilProduct
    {
        return $this->products->get($productUuid);
    }
}
