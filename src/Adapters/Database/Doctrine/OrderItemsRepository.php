<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Order\OrderItem;
use BelkinDom\Store\Order\OrderItems;
use Doctrine\Common\Persistence\ObjectManager;

final class OrderItemsRepository implements OrderItems
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
     * @param OrderItem $galleryItem
     */
    public function save(OrderItem $galleryItem): void
    {
        $this->objectManager->persist($galleryItem);
        $this->objectManager->flush();
    }

    /**
     * @param OrderItem $galleryItem
     */
    public function update(OrderItem $galleryItem): void
    {
        $this->objectManager->merge($galleryItem);
        $this->objectManager->flush();
    }

    /**
     * @param OrderItem $galleryItem
     */
    public function remove(OrderItem $galleryItem): void
    {
        $this->objectManager->remove($galleryItem);
        $this->objectManager->flush();
    }
}
