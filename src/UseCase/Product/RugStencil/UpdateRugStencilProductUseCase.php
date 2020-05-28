<?php

namespace BelkinDom\UseCase\Product\RugStencil;

use BelkinDom\Store\Product\RugStencil\RugStencil;
use BelkinDom\Store\Product\RugStencil\RugStencilUuid;
use BelkinDom\Store\Product\RugStencilProduct;
use BelkinDom\Store\Product\RugStencilProducts;
use BelkinDom\UseCase\Product\Gallery\UpdateProductGalleryUseCase;

class UpdateRugStencilProductUseCase
{
    /**
     * @var RugStencilProducts
     */
    private $products;

    /**
     * @var CreateRugStencilUseCase
     */
    private $createRugStencilUseCase;

    /**
     * @var RemoveRugStencilUseCase
     */
    private $removeRugStencilUseCase;

    /**
     * @var UpdateProductGalleryUseCase
     */
    private $updateProductGalleryUseCase;

    public function __construct(RugStencilProducts $products, CreateRugStencilUseCase $createRugStencilUseCase, RemoveRugStencilUseCase $removeRugStencilUseCase, UpdateProductGalleryUseCase $updateProductGalleryUseCase)
    {
        $this->products = $products;
        $this->createRugStencilUseCase = $createRugStencilUseCase;
        $this->removeRugStencilUseCase = $removeRugStencilUseCase;
        $this->updateProductGalleryUseCase = $updateProductGalleryUseCase;
    }

    /**
     * @param RugStencilProduct $product
     * @param RugStencilProduct $updatedProduct
     */
    public function execute(RugStencilProduct $product, RugStencilProduct $updatedProduct)
    {
        $updatedGallery = $this->updateProductGalleryUseCase->execute($product->gallery(), $updatedProduct->gallery());

        $currentStencilsIds = array_map(function (RugStencil $rugStencil) {
            return (string) $rugStencil->rugStencilUuid();
        }, $product->stencils());

        $updatedStencilsIds = array_map(function (RugStencil $rugStencil) {
            return (string) $rugStencil->rugStencilUuid();
        }, $updatedProduct->stencils());

        // create new stencils
        $newStencilsIds = array_diff($updatedStencilsIds, $currentStencilsIds);
        foreach ($newStencilsIds as $id) {
            if ($stencil = $updatedProduct->getStencil(RugStencilUuid::existing($id))) {
                $this->createRugStencilUseCase->execute($stencil);
                $product->addStencil($stencil);
                $this->products->update($product);
            }
        }

        // delete removed stencils
        $removedStencilsIds = array_diff($currentStencilsIds, $updatedStencilsIds);
        foreach ($removedStencilsIds as $id) {
            if ($stencil = $product->getStencil(RugStencilUuid::existing($id))) {
                $product->removeStencil($stencil);
                $this->products->update($product);
                $this->removeRugStencilUseCase->execute($stencil);
            }
        }

        $product->update(
            $updatedProduct->price(),
            $updatedProduct->title(),
            $updatedProduct->summary(),
            $updatedProduct->description(),
            $updatedProduct->availability(),
            $updatedGallery
        );

        $this->products->update($product);
    }
}
