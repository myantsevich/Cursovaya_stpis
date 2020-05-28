<?php

namespace BelkinDom\Store\Product;

use BelkinDom\Store\Common\TranslatableContent;
use BelkinDom\Store\Money\Money;
use BelkinDom\Store\Product\Gallery\Gallery;
use BelkinDom\Store\Product\RugStencil\RugStencil;
use BelkinDom\Store\Product\RugStencil\RugStencilUuid;

class RugStencilProduct extends AbstractProduct
{
    /**
     * @var RugStencil[]
     */
    private $stencils;

    public function __construct(
        ProductUuid $productUuid,
        Money $price,
        TranslatableContent $title,
        TranslatableContent $summary,
        TranslatableContent $description,
        bool $availability,
        Gallery $gallery,
        array $stencils,
        \DateTimeImmutable $created
    ) {
        parent::__construct($productUuid, $price, $title, $summary, $description, $availability, $gallery, $created);

        $this->stencils = $stencils;
    }

    public function update(
        Money $price,
        TranslatableContent $title,
        TranslatableContent $summary,
        TranslatableContent $description,
        bool $availability,
        Gallery $gallery
    ) {
        $this->price = $price;
        $this->title = $title;
        $this->summary = $summary;
        $this->description = $description;
        $this->availability = $availability;
        $this->gallery = $gallery;
    }

    /**
     * @return RugStencil[]
     */
    public function stencils(): array
    {
        if (is_array($this->stencils)) {
            return $this->stencils;
        }

        if (is_object($this->stencils) && in_array('toArray', get_class_methods($this->stencils))) {
            return $this->stencils->toArray();
        }

        return [];
    }

    /**
     * @param RugStencilUuid $stencilUuid
     *
     * @return RugStencil|null
     */
    public function getStencil(RugStencilUuid $stencilUuid): ?RugStencil
    {
        $index = $this->getStencilIndex($stencilUuid);

        return is_int($index) ? $this->stencils()[$index] : null;
    }

    /**
     * @param RugStencil $stencil
     */
    public function addStencil(RugStencil $stencil): void
    {
        if (is_array($this->stencils)) {
            $this->stencils[] = $stencil;
        }

        if (is_object($this->stencils)
            && in_array('add', get_class_methods($this->stencils))
            && in_array('contains', get_class_methods($this->stencils))
            && !$this->stencils->contains($stencil)
        ) {
            $this->stencils->add($stencil);
        }
    }

    /**
     * @param RugStencil $stencil
     */
    public function removeStencil(RugStencil $stencil): void
    {
        if (is_array($this->stencils)) {
            $offset = $this->getStencilIndex($stencil->rugStencilUuid());

            if ($offset) {
                $this->stencils = array_splice($this->stencils, $offset, 1);
            }
        }

        if (is_object($this->stencils)
            && in_array('removeElement', get_class_methods($this->stencils))
            && in_array('contains', get_class_methods($this->stencils))
            && $this->stencils->contains($stencil)
        ) {
            $this->stencils->removeElement($stencil);
        }
    }

    /**
     * @param RugStencilUuid $stencilUuid
     *
     * @return int|null
     */
    private function getStencilIndex(RugStencilUuid $stencilUuid): ?int
    {
        foreach ($this->stencils() as $index => $item) {
            if ((string) $item->rugStencilUuid() === (string) $stencilUuid) {
                return $index;
            }
        }

        return null;
    }
}
