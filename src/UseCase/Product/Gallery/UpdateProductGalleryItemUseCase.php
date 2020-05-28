<?php

namespace BelkinDom\UseCase\Product\Gallery;

use BelkinDom\Store\Product\Gallery\GalleriesItems;
use BelkinDom\Store\Product\Gallery\GalleryItem;

class UpdateProductGalleryItemUseCase
{
    /**
     * @var GalleriesItems
     */
    private $galleriesItems;

    public function __construct(GalleriesItems $galleriesItems)
    {
        $this->galleriesItems = $galleriesItems;
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function execute(GalleryItem $galleryItem)
    {
        $this->galleriesItems->update($galleryItem);
    }
}
