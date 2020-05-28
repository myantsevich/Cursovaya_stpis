<?php

namespace BelkinDom\UseCase\Product\Gallery;

use BelkinDom\Store\Product\Gallery\Galleries;
use BelkinDom\Store\Product\Gallery\Gallery;

class CreateProductGalleryUseCase
{
    /**
     * @var Galleries
     */
    private $galleries;

    /**
     * @var CreateProductGalleryItemUseCase
     */
    private $createProductGalleryItemsUseCase;

    public function __construct(Galleries $galleries, CreateProductGalleryItemUseCase $createProductGalleryItemsUseCase)
    {
        $this->galleries = $galleries;
        $this->createProductGalleryItemsUseCase = $createProductGalleryItemsUseCase;
    }

    /**
     * @param Gallery $gallery
     */
    public function execute(Gallery $gallery)
    {
        foreach ($gallery->items() as $item) {
            $this->createProductGalleryItemsUseCase->execute($item);
        }

        $this->galleries->save($gallery);
    }
}
