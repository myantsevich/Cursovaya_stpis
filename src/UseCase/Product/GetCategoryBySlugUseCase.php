<?php

namespace BelkinDom\UseCase\Product;

use BelkinDom\Store\Product\Category\Categories;
use BelkinDom\Store\Product\Category\Category;
use BelkinDom\Store\Product\Category\CategoryNotFoundException;

class GetCategoryBySlugUseCase
{
    /**
     * @var Categories
     */
    private $categories;

    public function __construct(Categories $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param string $slug
     *
     * @return Category
     *
     * @throws CategoryNotFoundException
     */
    public function execute(string $slug): Category
    {
        return $this->categories->getBySlug($slug);
    }
}
