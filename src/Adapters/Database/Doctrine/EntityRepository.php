<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class EntityRepository extends BaseEntityRepository
{
    const
        OPERATOR_GT = 'gt',
        OPERATOR_LT = 'lt',
        OPERATOR_EQ = 'eq',
        OPERATOR_LTE = 'lte',
        OPERATOR_GTE = 'gte',
        OPERATOR_LIKE = 'like',
        OPERATOR_BETWEEN = 'between'
    ;

    /**
     * @param QueryBuilder $queryBuilder
     * @param Find $findRequest
     * @param string $alias
     * @param array $keys
     * @param array $operators
     * @param array $values
     *
     * @return Pagerfanta
     */
    public function createOperatorPaginator(
        QueryBuilder $queryBuilder,
        Find $findRequest,
        string $alias,
        array $keys = [],
        array $operators = [],
        array $values = []
    ): Pagerfanta {
        $this->applyCriteriaOperator($queryBuilder, $alias, $keys, $operators, $values);

        return $this->createPaginator($queryBuilder, $findRequest);
    }

    /**
     * @param QueryBuilder $qb
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function createPaginator(QueryBuilder $qb, Find $findRequest): Pagerfanta
    {
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qb, true));
        $pagerfanta->setMaxPerPage($findRequest->limit());
        $pagerfanta->setCurrentPage($findRequest->page());

        return $pagerfanta;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $alias
     * @param array $keys
     * @param array $operators
     * @param array $values
     *
     * @return QueryBuilder
     */
    protected function applyCriteriaOperator(
        QueryBuilder $queryBuilder,
        string $alias,
        array $keys = [],
        array $operators = [],
        array $values = []
    ) {
        foreach ($keys as $position => $value) {
            if (null === $value) continue;

            $name = $this->getPropertyName($alias, $value);
            $parameter = ':' . str_replace('.', '_', $value) . $position;
            $operation = $operators[$position];
            $parameterValue = $values[$position];

            switch ($operation) {
                case static::OPERATOR_GT:
                    $queryBuilder->andWhere($queryBuilder->expr()->gt($name, $parameter));
                    break;

                case static::OPERATOR_LT:

                    $queryBuilder->andWhere($queryBuilder->expr()->lt($name, $parameter));
                    break;

                case static::OPERATOR_GTE:
                    $queryBuilder->andWhere($queryBuilder->expr()->gte($name, $parameter));
                    break;

                case static::OPERATOR_LTE:
                    $queryBuilder->andWhere($queryBuilder->expr()->lte($name, $parameter));
                    break;

                case static::OPERATOR_LIKE:
                    $queryBuilder->andWhere($queryBuilder->expr()->like($name, $parameter));
                    $parameterValue = '%' . $parameterValue . '%';
                    break;

                case static::OPERATOR_BETWEEN:
                    $queryBuilder->andWhere($queryBuilder->expr()->between($name, $values[0], $values[1]));
                    break;

                case static::OPERATOR_EQ:
                default:
                    if (null === $parameterValue) {
                        $queryBuilder->andWhere($queryBuilder->expr()->isNull($parameter));
                    } elseif (is_array($parameterValue)) {
                        $queryBuilder->andWhere($queryBuilder->expr()->in($name, $parameter));
                    } elseif ('' !== $parameterValue) {
                        $queryBuilder->andWhere($queryBuilder->expr()->eq($name, $parameter));
                    }
            }

            $queryBuilder->setParameter($parameter, $parameterValue);
        }
        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $name
     *
     * @return string
     */
    protected function getPropertyName(string $alias, string $name): string
    {
        return (false === $this->startsWith($name, $alias)) ? $alias . '.' . $name : $name;
    }

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    private function startsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}
