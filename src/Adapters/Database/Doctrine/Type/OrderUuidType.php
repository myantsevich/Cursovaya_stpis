<?php

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\Order\OrderUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class OrderUuidType extends Type
{
    const ORDER_UUID = 'orderUuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : OrderUuid::existing($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::ORDER_UUID;
    }
}
