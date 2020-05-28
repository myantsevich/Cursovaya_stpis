<?php

namespace BelkinDom\Store\Product;

use BelkinDom\Store\Common\TranslatableContent;
use BelkinDom\Store\Money\Money;
use BelkinDom\Store\Product\Gallery\Gallery;

abstract class AbstractProduct
{
    /**
     * @var ProductUuid
     */
    protected $productUuid;

    /**
     * @var Money
     */
    protected $price;

    /**
     * @var TranslatableContent
     */
    protected $title;

    /**
     * Short description of the product
     *
     * @var TranslatableContent
     */
    protected $summary;

    /**
     * Long description of the product
     *
     * @var TranslatableContent
     */
    protected $description;

    /**
     * @var bool
     */
    protected $availability;

    /**
     * @var Gallery
     */
    protected $gallery;

    /**
     * @var \DateTimeImmutable
     */
    protected $created;

    public function __construct(
        ProductUuid $productUuid,
        Money $price,
        TranslatableContent $title,
        TranslatableContent $summary,
        TranslatableContent $description,
        bool $availability,
        Gallery $gallery,
        \DateTimeImmutable $created
    ) {
        $this->productUuid = $productUuid;
        $this->price = $price;
        $this->title = $title;
        $this->summary = $summary;
        $this->description = $description;
        $this->availability = $availability;
        $this->gallery = $gallery;
        $this->created = $created;
    }

    /**
     * @return ProductUuid
     */
    public function productUuid(): ProductUuid
    {
        return $this->productUuid;
    }

    /**
     * @return Money
     */
    public function price(): Money
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function priceAmount(): float
    {
        return $this->price->amount();
    }

    /**
     * @return TranslatableContent
     */
    public function title(): TranslatableContent
    {
        return $this->title;
    }

    /**
     * @return TranslatableContent
     */
    public function summary(): TranslatableContent
    {
        return $this->summary;
    }

    /**
     * @return TranslatableContent
     */
    public function description(): TranslatableContent
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function availability(): bool
    {
        return $this->availability;
    }

    /**
     * @return Gallery
     */
    public function gallery(): Gallery
    {
        return $this->gallery;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }
}
