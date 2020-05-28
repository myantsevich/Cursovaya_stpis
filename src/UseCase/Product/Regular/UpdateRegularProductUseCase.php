<?php

namespace BelkinDom\UseCase\Product\Regular;

use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\Products;
use BelkinDom\UseCase\Product\Gallery\UpdateProductGalleryUseCase;

class UpdateRegularProductUseCase
{
    /**
     * @var Products
     */
    private $products;

    /**
     * @var UpdateProductGalleryUseCase
     */
    private $updateProductGalleryUseCase;

    public function __construct(Products $products, UpdateProductGalleryUseCase $updateProductGalleryUseCase)
    {
        $this->products = $products;
        $this->updateProductGalleryUseCase = $updateProductGalleryUseCase;
    }

    /**
     * @param Product $product
     * @param Product $updatedProduct
     */
    public function execute(Product $product, Product $updatedProduct)
    {
        $updatedGallery = $this->updateProductGalleryUseCase->execute($product->gallery(), $updatedProduct->gallery());

        $product = new Product(
            $updatedProduct->productUuid(),
            $updatedProduct->price(),
            $updatedProduct->title(),
            $updatedProduct->summary(),
            $updatedProduct->description(),
            $updatedProduct->availability(),
            $updatedGallery,
            $updatedProduct->category(),
            $updatedProduct->material(),
            $updatedProduct->created()
        );

        $this->products->update($product);
    }
}
