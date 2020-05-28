<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Faq\Faq;
use BelkinDom\Store\Faq\FaqNotFoundException;
use BelkinDom\Store\Faq\Faqs;

final class FaqRepository extends EntityRepository implements Faqs
{
    /**
     * @return Faq
     *
     * @throws FaqNotFoundException
     */
    public function get(): Faq
    {
        $faq = $this->findAll();

        if (count($faq) === 0) {
            throw new FaqNotFoundException();
        }

        return $faq[0];
    }

    /**
     * @param Faq $faq
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Faq $faq)
    {
        $this->getEntityManager()->persist($faq);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Faq $faq
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Faq $faq)
    {
        $this->getEntityManager()->merge($faq);
        $this->getEntityManager()->flush();
    }
}
