<?php declare(strict_types=1);

namespace BelkinDom\Store\Common;

class TranslatableContent implements \JsonSerializable
{
    /**
     * @var array
     */
    private $translations;

    /**
     * TranslatableContent constructor.
     */
    public function __construct()
    {
        $this->translations = [];
    }

    /**
     * @param string $locale
     *
     * @return string|null
     */
    public function translate(string $locale)
    {
        if (isset($this->translations[$locale])) {
            return $this->translations[$locale];
        }

        return null;
    }

    /**
     * @param string $locale
     * @param string $value
     */
    public function addTranslation(string $locale, string $value)
    {
        $this->translations[$locale] = $value;
    }
    
    /**
     * @return array
     */
    public function content()
    {
        return $this->translations;
    }

    /**
     * @param array $translations
     */
    public function updateContent(array $translations)
    {
        $this->translations = $translations;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->translations;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->translations);
    }
}
