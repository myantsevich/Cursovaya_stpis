<?php

namespace BelkinDom\UseCase\Product\Regular;

use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\Products;
use BelkinDom\UseCase\Product\Gallery\CreateProductGalleryUseCase;

class CreateRegularProductUseCase
{
    /**
     * @var Products
     */
    private $products;

    /**
     * @var CreateProductGalleryUseCase
     */
    private $createProductGalleryUseCase;

    public function __construct(Products $products, CreateProductGalleryUseCase $createProductGalleryUseCase)
    {
        $this->products = $products;
        $this->createProductGalleryUseCase = $createProductGalleryUseCase;
    }

    /**
     * @param Product $product
     */
    public function execute(Product $product)
    {
        $this->createProductGalleryUseCase->execute($product->gallery());
        $this->products->save($product);
    }
}
