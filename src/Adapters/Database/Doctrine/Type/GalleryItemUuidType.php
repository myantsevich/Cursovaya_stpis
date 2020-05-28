<?php

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\Product\Gallery\GalleryItemUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class GalleryItemUuidType extends Type
{
    const GALLERY_ITEM_UUID = 'galleryItemUuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : GalleryItemUuid::existing($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::GALLERY_ITEM_UUID;
    }
}
