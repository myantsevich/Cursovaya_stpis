<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\Store\Product\RugStencilProduct;
use BelkinDom\Store\Product\RugStencilProducts;
use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

final class RugStencilProductsRepository extends EntityRepository implements RugStencilProducts
{
    /**
     * @param ProductUuid $uuid
     *
     * @return RugStencilProduct
     *
     * @throws ProductNotFoundException
     */
    public function get(ProductUuid $uuid): RugStencilProduct
    {
        $product = $this->find((string) $uuid);

        if (!$product instanceof RugStencilProduct) {
            throw new ProductNotFoundException($uuid);
        }

        return $product;
    }

    /**
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function list(Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('product');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param RugStencilProduct $product
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(RugStencilProduct $product)
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @param RugStencilProduct $product
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(RugStencilProduct $product)
    {
        $this->getEntityManager()->merge($product);
        $this->getEntityManager()->flush();
    }
}
