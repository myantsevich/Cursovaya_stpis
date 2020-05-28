<?php

namespace BelkinDom\UseCase\Product\Gallery;

use BelkinDom\Store\Product\Gallery\Galleries;
use BelkinDom\Store\Product\Gallery\Gallery;
use BelkinDom\Store\Product\Gallery\GalleryItem;
use BelkinDom\Store\Product\Gallery\GalleryItemUuid;

class UpdateProductGalleryUseCase
{
    /**
     * @var Galleries
     */
    private $galleries;

    /**
     * @var CreateProductGalleryItemUseCase
     */
    private $createProductGalleryItemsUseCase;

    /**
     * @var RemoveProductGalleryItemUseCase
     */
    private $removeProductGalleryItemsUseCase;

    /**
     * @var UpdateProductGalleryItemUseCase
     */
    private $updateProductGalleryItemsUseCase;

    public function __construct(
        Galleries $galleries,
        CreateProductGalleryItemUseCase $createProductGalleryItemsUseCase,
        RemoveProductGalleryItemUseCase $removeProductGalleryItemsUseCase,
        UpdateProductGalleryItemUseCase $updateProductGalleryItemsUseCase
    ) {
        $this->galleries = $galleries;
        $this->createProductGalleryItemsUseCase = $createProductGalleryItemsUseCase;
        $this->removeProductGalleryItemsUseCase = $removeProductGalleryItemsUseCase;
        $this->updateProductGalleryItemsUseCase = $updateProductGalleryItemsUseCase;
    }

    /**
     * @param Gallery $gallery
     * @param Gallery $updatedGallery
     *
     * @return Gallery
     */
    public function execute(Gallery $gallery, Gallery $updatedGallery): Gallery
    {
        $currentItemsIds = array_map(function (GalleryItem $item) {
            return (string) $item->galleryItemUuid();
        }, $gallery->items());

        $updatedItemsIds = array_map(function (GalleryItem $item) {
            return (string) $item->galleryItemUuid();
        }, $updatedGallery->items());

        // create new gallery items
        $newItemsIds = array_diff($updatedItemsIds, $currentItemsIds);
        foreach ($newItemsIds as $id) {
            if ($item = $updatedGallery->getItem(GalleryItemUuid::existing($id))) {
                $this->createProductGalleryItemsUseCase->execute($item);
                $gallery->addItem($item);
                $this->galleries->update($gallery);
            }
        }

        // delete removed gallery items
        $removedItemsIds = array_diff($currentItemsIds, $updatedItemsIds);
        foreach ($removedItemsIds as $id) {
            if ($item = $gallery->getItem(GalleryItemUuid::existing($id))) {
                $gallery->removeItem($item);
                $this->galleries->update($gallery);
                $this->removeProductGalleryItemsUseCase->execute($item);
            }
        }

        // update other gallery items
        $updatedItemsIds = array_intersect($currentItemsIds, $updatedItemsIds);
        foreach ($updatedItemsIds as $id) {
            if ($item = $gallery->getItem(GalleryItemUuid::existing($id))) {
                $this->updateProductGalleryItemsUseCase->execute($item);
            }
        }

        $this->galleries->update($gallery);

        return $gallery;
    }
}
