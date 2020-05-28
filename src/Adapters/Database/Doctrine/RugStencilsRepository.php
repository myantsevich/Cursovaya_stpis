<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Product\RugStencil\RugStencil;
use BelkinDom\Store\Product\RugStencil\RugStencils;

final class RugStencilsRepository extends EntityRepository implements RugStencils
{
    /**
     * @param RugStencil $rugStencil
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(RugStencil $rugStencil)
    {
        $this->getEntityManager()->persist($rugStencil);
        $this->getEntityManager()->flush();
    }

    /**
     * @param RugStencil $rugStencil
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(RugStencil $rugStencil)
    {
        $this->getEntityManager()->merge($rugStencil);
        $this->getEntityManager()->flush();
    }

    /**
     * @param RugStencil $rugStencil
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(RugStencil $rugStencil)
    {
        $this->getEntityManager()->remove($rugStencil);
        $this->getEntityManager()->flush();
    }
}
