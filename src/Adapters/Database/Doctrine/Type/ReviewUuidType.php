<?php

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\Review\ReviewUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ReviewUuidType extends Type
{
    const REVIEW_UUID = 'reviewUuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : ReviewUuid::existing($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::REVIEW_UUID;
    }
}
