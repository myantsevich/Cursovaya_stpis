<?php

namespace BelkinDom\Store\Product;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface RugStencilProducts
{
    /**
     * @param ProductUuid $uuid
     *
     * @throws ProductNotFoundException
     *
     * @return RugStencilProduct
     */
    public function get(ProductUuid $uuid): RugStencilProduct;

    /**
     * @param Find $findRequest
     *
     * @return RugStencilProduct[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param RugStencilProduct $product
     */
    public function save(RugStencilProduct $product);

    /**
     * @param RugStencilProduct $product
     */
    public function update(RugStencilProduct $product);
}
