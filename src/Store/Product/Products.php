<?php

namespace BelkinDom\Store\Product;

use BelkinDom\DTO\Product\ProductsTotals;
use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Product\Category\CategoryUuid;
use Pagerfanta\Pagerfanta;

interface Products
{
    /**
     * @param ProductUuid $uuid
     *
     * @throws ProductNotFoundException
     *
     * @return Product
     */
    public function get(ProductUuid $uuid): Product;

    /**
     * @param CategoryUuid $uuid
     * @param Find $findRequest
     *
     * @return Product[]|Pagerfanta
     */
    public function listByCategory(CategoryUuid $uuid, Find $findRequest): Pagerfanta;

    /**
     * @return ProductsTotals
     */
    public function getTotalsByCategory(): ProductsTotals;

    /**
     * @param Find $findRequest
     *
     * @return Product[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param Product $product
     */
    public function save(Product $product);

    /**
     * @param Product $product
     */
    public function update(Product $product);
}
