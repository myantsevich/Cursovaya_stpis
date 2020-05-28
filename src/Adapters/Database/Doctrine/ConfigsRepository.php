<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Web\ConfigNotFoundException;
use BelkinDom\Store\Web\Configs;
use BelkinDom\Store\Web\Config;

final class ConfigsRepository extends EntityRepository implements Configs
{
    /**
     * @return Config
     */
    public function get(): Config
    {
        $result = $this->findAll();

        if (0 === count($result)) {
            throw new ConfigNotFoundException();
        }

        return array_shift($result);
    }

    /**
     * @param Config $config
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Config $config)
    {
        $this->getEntityManager()->persist($config);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Config $config
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Config $config)
    {
        $this->getEntityManager()->merge($config);
        $this->getEntityManager()->flush();
    }
}
