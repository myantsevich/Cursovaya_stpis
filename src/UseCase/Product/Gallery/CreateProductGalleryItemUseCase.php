<?php

namespace BelkinDom\UseCase\Product\Gallery;

use BelkinDom\Store\Product\Gallery\GalleriesItems;
use BelkinDom\Store\Product\Gallery\GalleryItem;
use BelkinDom\UseCase\File\CreateFileUseCase;

class CreateProductGalleryItemUseCase
{
    /**
     * @var GalleriesItems
     */
    private $galleriesItems;

    /**
     * @var CreateFileUseCase
     */
    private $createFileUseCase;

    public function __construct(GalleriesItems $galleriesItems, CreateFileUseCase $createFileUseCase)
    {
        $this->galleriesItems = $galleriesItems;
        $this->createFileUseCase = $createFileUseCase;
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function execute(GalleryItem $galleryItem)
    {
        $this->createFileUseCase->execute($galleryItem->image());
        $this->galleriesItems->save($galleryItem);
    }
}
