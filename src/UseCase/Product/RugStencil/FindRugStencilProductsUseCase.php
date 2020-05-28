<?php

namespace BelkinDom\UseCase\Product\RugStencil;

use BelkinDom\Store\Product\RugStencilProduct;
use BelkinDom\Store\Product\RugStencilProducts;
use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;

class FindRugStencilProductsUseCase
{
    /**
     * @var RugStencilProducts
     */
    private $rugStencilProducts;

    public function __construct(RugStencilProducts $rugStencilProducts)
    {
        $this->rugStencilProducts = $rugStencilProducts;
    }

    /**
     * @param Find $findRequest
     *
     * @return RugStencilProduct[]|Pagerfanta
     *
     * @throws OutOfRangeCurrentPageException
     */
    public function execute(Find $findRequest)
    {
        return $this->rugStencilProducts->list($findRequest);
    }
}
