<?php

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\Order\OrderItemUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class OrderItemUuidType extends Type
{
    const ORDER_ITEM_UUID = 'orderItemUuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : OrderItemUuid::existing($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::ORDER_ITEM_UUID;
    }
}
