<?php

namespace BelkinDom\UseCase\Product\Regular;

use BelkinDom\Store\Product\Category\Category;
use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\Products;
use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;

class FindRegularProductsByCategoryUseCase
{
    /**
     * @var Products
     */
    private $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param Category $category
     * @param Find $findRequest
     *
     * @return Product[]|Pagerfanta
     *
     * @throws OutOfRangeCurrentPageException
     */
    public function execute(Category $category, Find $findRequest)
    {
        return $this->products->listByCategory($category->categoryUuid(), $findRequest);
    }
}
