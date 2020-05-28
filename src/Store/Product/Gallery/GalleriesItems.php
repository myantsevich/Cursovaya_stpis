<?php

namespace BelkinDom\Store\Product\Gallery;

interface GalleriesItems
{
    /**
     * @param GalleryItem $galleryItem
     */
    public function save(GalleryItem $galleryItem): void;

    /**
     * @param GalleryItem $galleryItem
     */
    public function update(GalleryItem $galleryItem): void;

    /**
     * @param GalleryItem $galleryItem
     */
    public function remove(GalleryItem $galleryItem): void;
}
