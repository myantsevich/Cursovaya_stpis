<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Product\ProductsTotals;
use BelkinDom\DTO\Product\ProductsTotalsItem;
use BelkinDom\Store\Product\Category\CategoryUuid;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\Products;
use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

final class ProductsRepository extends EntityRepository implements Products
{
    /**
     * @param ProductUuid $uuid
     *
     * @return Product
     *
     * @throws ProductNotFoundException
     */
    public function get(ProductUuid $uuid): Product
    {
        $product = $this->find((string) $uuid);

        if (!$product instanceof Product) {
            throw new ProductNotFoundException($uuid);
        }

        return $product;
    }

    /**
     * @param CategoryUuid $uuid
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function listByCategory(CategoryUuid $uuid, Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('product');
        $qb
            ->andWhere($qb->expr()->eq('product.category', ':category_uuid'))
            ->setParameter(':category_uuid', (string) $uuid)
        ;

        return $this->createPaginator($qb, $findRequest);
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
     * @return ProductsTotals
     */
    public function getTotalsByCategory(): ProductsTotals
    {
        $qb = $this->createQueryBuilder('product');
        $qb
            ->select('count(product) as total')
            ->addSelect('category.categoryUuid')
            ->innerJoin('product.category', 'category')
            ->groupBy('category')
        ;

        $result = $qb->getQuery()->getArrayResult();
        $items = [];

        foreach ($result as $value) {
            $items[] = new ProductsTotalsItem($value['categoryUuid'], (int) $value['total']);
        }

        return new ProductsTotals($items);
    }

    /**
     * @param Product $product
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Product $product)
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Product $product
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Product $product)
    {
        $this->getEntityManager()->merge($product);
        $this->getEntityManager()->flush();
    }
}
