<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Product\Gallery\GalleriesItems;
use BelkinDom\Store\Product\Gallery\GalleryItem;
use Doctrine\Common\Persistence\ObjectManager;

final class ProductsGalleriesItemsRepository implements GalleriesItems
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function save(GalleryItem $galleryItem): void
    {
        $this->objectManager->persist($galleryItem);
        $this->objectManager->flush();
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function update(GalleryItem $galleryItem): void
    {
        $this->objectManager->merge($galleryItem);
        $this->objectManager->flush();
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function remove(GalleryItem $galleryItem): void
    {
        $this->objectManager->remove($galleryItem);
        $this->objectManager->flush();
    }
}
