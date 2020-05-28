<?php declare(strict_types=1);

namespace BelkinDom\Adapters\Database\Doctrine\Type;

use BelkinDom\Store\Common\TranslatableContent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TranslatableType extends Type
{
    const TRANSLATABLE = 'translatable';

    public function getName()
    {
        return self::TRANSLATABLE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\'';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof TranslatableContent) {
            $value = json_encode($value);
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (strlen($value) == 0) {
            return null;
        }

        $content = new TranslatableContent();

        $encoded = json_decode($value, true);
        foreach ($encoded as $locale => $value) {
            $content->addTranslation($locale, $value);
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
