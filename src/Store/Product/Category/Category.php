<?php

namespace BelkinDom\Store\Product\Category;

class Category
{
    /**
     * @var CategoryUuid
     */
    protected $categoryUuid;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    public function __construct(CategoryUuid $categoryUuid, string $title, string $slug)
    {
        $this->categoryUuid = $categoryUuid;
        $this->title = $title;
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->categoryUuid;
    }

    /**
     * @param string $title
     * @param string $slug
     *
     * @return Category
     */
    public static function generated(string $title, string $slug): Category
    {
        return new self(CategoryUuid::generated(), $title, $slug);
    }

    /**
     * @return CategoryUuid
     */
    public function categoryUuid(): CategoryUuid
    {
        return $this->categoryUuid;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function slug(): string
    {
        return $this->slug;
    }
}
