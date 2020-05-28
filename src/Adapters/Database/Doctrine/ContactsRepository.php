<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Contact\Contacts;
use BelkinDom\Store\Contact\Contact;
use BelkinDom\Store\Contact\ContactNotFoundException;
use BelkinDom\Store\Contact\ContactUuid;
use Pagerfanta\Pagerfanta;

final class ContactsRepository extends EntityRepository implements Contacts
{
    /**
     * @param ContactUuid $uuid
     *
     * @return Contact
     *
     * @throws ContactNotFoundException
     */
    public function get(ContactUuid $uuid): Contact
    {
        $order = $this->find((string) $uuid);

        if (!$order instanceof Contact) {
            throw new ContactNotFoundException($uuid);
        }

        return $order;
    }

    /**
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function list(Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('individual_orders');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param Contact $order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $order)
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Contact $order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Contact $order)
    {
        $this->getEntityManager()->merge($order);
        $this->getEntityManager()->flush();
    }
}
