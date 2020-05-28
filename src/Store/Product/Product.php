<?php

namespace BelkinDom\Store\Product;

use BelkinDom\Store\Common\TranslatableContent;
use BelkinDom\Store\Money\Money;
use BelkinDom\Store\Product\Category\Category;
use BelkinDom\Store\Product\Gallery\Gallery;

class Product extends AbstractProduct
{
    /**
     * @var TranslatableContent
     */
    private $material;

    /**
     * @var Category
     */
    private $category;

    public function __construct(
        ProductUuid $productUuid,
        Money $price,
        TranslatableContent $title,
        TranslatableContent $summary,
        TranslatableContent $description,
        bool $availability,
        Gallery $gallery,
        Category $category,
        TranslatableContent $material,
        \DateTimeImmutable $created
    ) {
        parent::__construct($productUuid, $price, $title, $summary, $description, $availability, $gallery, $created);

        $this->material = $material;
        $this->category = $category;
    }

    /**
     * @return TranslatableContent
     */
    public function material(): TranslatableContent
    {
        return $this->material;
    }

    /**
     * @return Category
     */
    public function category(): Category
    {
        return $this->category;
    }
}
