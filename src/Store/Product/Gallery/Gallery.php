<?php

namespace BelkinDom\Store\Product\Gallery;

class Gallery
{
    /**
     * @var GalleryUuid
     */
    private $galleryUuid;

    /**
     * @var GalleryItem[]
     */
    private $items;

    public function __construct(GalleryUuid $galleryUuid, array $items)
    {
        $this->galleryUuid = $galleryUuid;
        $this->items = $items;
    }

    public static function generated(array $items): Gallery
    {
        return new self(GalleryUuid::generated(), $items);
    }

    /**
     * @return GalleryUuid
     */
    public function galleryUuid(): GalleryUuid
    {
        return $this->galleryUuid;
    }

    /**
     * @return GalleryItem|null
     */
    public function mainItem()
    {
        $items = $this->items();

        foreach ($items as $item) {
            if ($item->isMain()) {
                return $item;
            }
        }

        return count($items) > 0 ? $items[0] : null;
    }

    /**
     * @return GalleryItem[]
     */
    public function items(): array
    {
        if (is_array($this->items)) {
            return $this->items;
        }

        if (is_object($this->items) && in_array('toArray', get_class_methods($this->items))) {
            return $this->items->toArray();
        }

        return [];
    }

    /**
     * @param GalleryItemUuid $galleryItemUuid
     *
     * @return GalleryItem|null
     */
    public function getItem(GalleryItemUuid $galleryItemUuid): ?GalleryItem
    {
        $index = $this->getItemIndex($galleryItemUuid);

        return is_int($index) ? $this->items()[$index] : null;
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function addItem(GalleryItem $galleryItem): void
    {
        if (is_array($this->items)) {
            $this->items[] = $galleryItem;
        }

        if (is_object($this->items)
            && in_array('add', get_class_methods($this->items))
            && in_array('contains', get_class_methods($this->items))
            && !$this->items->contains($galleryItem)
        ) {
            $this->items->add($galleryItem);
        }
    }

    /**
     * @param GalleryItem $galleryItem
     */
    public function removeItem(GalleryItem $galleryItem): void
    {
        if (is_array($this->items)) {
            $offset = $this->getItemIndex($galleryItem->galleryItemUuid());

            if ($offset) {
                $this->items = array_splice($this->items, $offset, 1);
            }
        }

        if (is_object($this->items)
            && in_array('removeElement', get_class_methods($this->items))
            && in_array('contains', get_class_methods($this->items))
            && $this->items->contains($galleryItem)
        ) {
            $this->items->removeElement($galleryItem);
        }
    }

    /**
     * @param GalleryItemUuid $galleryItemUuid
     *
     * @return int|null
     */
    private function getItemIndex(GalleryItemUuid $galleryItemUuid): ?int
    {
        foreach ($this->items() as $index => $item) {
            if ((string) $item->galleryItemUuid() === (string) $galleryItemUuid) {
                return $index;
            }
        }

        return null;
    }
}
