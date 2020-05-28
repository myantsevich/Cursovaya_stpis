<?php

namespace BelkinDom\UseCase\Product;

use BelkinDom\Store\Product\AbstractProduct;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Product\Regular\GetRegularProductUseCase;
use BelkinDom\UseCase\Product\RugStencil\GetRugStencilProductUseCase;

class GetProductUseCase
{
    /**
     * @var GetRegularProductUseCase
     */
    private $getRegularProductUseCase;

    /**
     * @var GetRugStencilProductUseCase
     */
    private $getRugStencilProductUseCase;

    public function __construct(
        GetRegularProductUseCase $getRegularProductUseCase,
        GetRugStencilProductUseCase $getRugStencilProductUseCase
    ) {
        $this->getRegularProductUseCase = $getRegularProductUseCase;
        $this->getRugStencilProductUseCase = $getRugStencilProductUseCase;
    }

    /**
     * @param ProductUuid $productUuid
     *
     * @return AbstractProduct
     *
     * @throws ProductNotFoundException
     */
    public function execute(ProductUuid $productUuid): AbstractProduct
    {
        try {
            $product = $this->getRegularProductUseCase->execute($productUuid);
        } catch (ProductNotFoundException $x) {
            $product = $this->getRugStencilProductUseCase->execute($productUuid);
        }

        return $product;
    }
}
