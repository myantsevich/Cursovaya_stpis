<?php

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\File\FileUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class FileUuidType extends Type
{
    const FILE_UUID = 'fileUuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : FileUuid::existing($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::FILE_UUID;
    }
}
