<?php

namespace BelkinDom\UseCase\Product\RugStencil;

use BelkinDom\Store\Product\RugStencilProduct;
use BelkinDom\Store\Product\RugStencilProducts;
use BelkinDom\UseCase\Product\Gallery\CreateProductGalleryUseCase;

class CreateRugStencilProductUseCase
{
    /**
     * @var RugStencilProducts
     */
    private $rugStencilProducts;

    /**
     * @var CreateRugStencilUseCase
     */
    private $createRugStencilUseCase;

    /**
     * @var CreateProductGalleryUseCase
     */
    private $createProductGalleryUseCase;

    public function __construct(
        RugStencilProducts $rugStencilProducts,
        CreateRugStencilUseCase $createRugStencilUseCase,
        CreateProductGalleryUseCase $createProductGalleryUseCase
    ) {
        $this->rugStencilProducts = $rugStencilProducts;
        $this->createRugStencilUseCase = $createRugStencilUseCase;
        $this->createProductGalleryUseCase = $createProductGalleryUseCase;
    }

    /**
     * @param RugStencilProduct $product
     */
    public function execute(RugStencilProduct $product)
    {
        $this->createProductGalleryUseCase->execute($product->gallery());

        foreach ($product->stencils() as $stencil) {
            $this->createRugStencilUseCase->execute($stencil);
        }

        $this->rugStencilProducts->save($product);
    }
}
