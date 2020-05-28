<?php

namespace BelkinDom\UseCase\Product\Gallery;

use BelkinDom\Store\Product\Gallery\GalleriesItems;
use BelkinDom\Store\Product\Gallery\GalleryItem;
use BelkinDom\UseCase\File\CreateFileUseCase;
use BelkinDom\UseCase\File\RemoveFileUseCase;

class RemoveProductGalleryItemUseCase
{
    /**
     * @var GalleriesItems
     */
    private $galleriesItems;

    /**
     * @var CreateFileUseCase
     */
    private $removeFileUseCase;

    public function __construct(GalleriesItems $galleriesItems, RemoveFileUseCase $removeFileUseCase)
    {
        $this->galleriesItems = $galleriesItems;
        $this->removeFileUseCase = $removeFileUseCase;
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function execute(GalleryItem $galleryItem)
    {
        $this->removeFileUseCase->execute($galleryItem->image());
        $this->galleriesItems->remove($galleryItem);
    }
}
