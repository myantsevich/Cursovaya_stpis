<?php

namespace BelkinDom\Store\Product\Gallery;

use BelkinDom\Store\File\File;

class GalleryItem
{
    /**
     * @var GalleryItemUuid
     */
    private $galleryItemUuid;

    /**
     * @var File
     */
    private $image;

    /**
     * @var boolean
     */
    private $isMain;

    public function __construct(GalleryItemUuid $galleryItemUuid, File $image, bool $isMain)
    {
        $this->galleryItemUuid = $galleryItemUuid;
        $this->image = $image;
        $this->isMain = $isMain;
    }

    public static function generated(File $image, bool $isMain): GalleryItem
    {
        return new self(GalleryItemUuid::generated(), $image, $isMain);
    }

    /**
     * @return GalleryItemUuid
     */
    public function galleryItemUuid(): GalleryItemUuid
    {
        return $this->galleryItemUuid;
    }

    /**
     * @return File
     */
    public function image(): File
    {
        return $this->image;
    }

    /**
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->isMain;
    }
}
