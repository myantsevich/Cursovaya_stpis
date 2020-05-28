<?php

namespace BelkinDom\UseCase\Product;

use BelkinDom\Store\Product\Category\Categories;
use BelkinDom\Store\Product\Category\Category;

class ViewCategoriesListUseCase
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
     * @return Category[]
     */
    public function execute(): array
    {
        return $this->categories->list();
    }
}
