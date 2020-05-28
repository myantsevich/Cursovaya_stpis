<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Product\Gallery\Galleries;
use BelkinDom\Store\Product\Gallery\Gallery;
use Doctrine\Common\Persistence\ObjectManager;

final class ProductsGalleriesRepository implements Galleries
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
     * @param Gallery $gallery
     */
    public function save(Gallery $gallery): void
    {
        $this->objectManager->persist($gallery);
        $this->objectManager->flush();
    }

    /**
     * @param Gallery $gallery
     */
    public function update(Gallery $gallery): void
    {
        $this->objectManager->merge($gallery);
        $this->objectManager->flush();
    }
}
