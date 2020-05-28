<?php

namespace BelkinDom\DTO\Product;

class BaseProduct
{
    public $productUuid;

    public $price;

    public $title;

    public $summary;

    public $description;

    public $gallery;

    public $availability = true;

    public $created;
}
