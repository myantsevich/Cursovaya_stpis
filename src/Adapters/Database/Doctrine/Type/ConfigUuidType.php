<?php

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\Web\ConfigUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ConfigUuidType extends Type
{
    const CONFIG_UUID = 'configUuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : ConfigUuid::existing($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::CONFIG_UUID;
    }
}
