<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Partner\Partners;
use BelkinDom\Store\Partner\Partner;
use BelkinDom\Store\Partner\PartnerNotFoundException;
use BelkinDom\Store\Partner\PartnerUuid;
use Pagerfanta\Pagerfanta;

final class PartnersRepository extends EntityRepository implements Partners
{
    /**
     * @param PartnerUuid $uuid
     *
     * @return Partner
     *
     * @throws PartnerNotFoundException
     */
    public function get(PartnerUuid $uuid): Partner
    {
        $partner = $this->find((string) $uuid);

        if (!$partner instanceof Partner) {
            throw new PartnerNotFoundException($uuid);
        }

        return $partner;
    }

    /**
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function list(Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('partner');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param Partner $partner
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Partner $partner)
    {
        $this->getEntityManager()->persist($partner);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Partner $partner
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Partner $partner)
    {
        $this->getEntityManager()->merge($partner);
        $this->getEntityManager()->flush();
    }
}
