<?php

namespace BelkinDom\UseCase\Product;

use BelkinDom\Store\Product\Category\Categories;
use BelkinDom\Store\Product\Category\Category;
use BelkinDom\Store\Product\Category\CategoryNotFoundException;
use BelkinDom\Store\Product\Category\CategoryUuid;

class ImportCategoriesUseCase
{
    /**
     * @var Categories
     */
    private $categories;

    /**
     * Array of categories raw data
     *
     * @var array
     */
    private $rawData;

    public function __construct(Categories $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param array $rawData
     */
    public function setCategoryData(array $rawData): void
    {
        $this->rawData = $rawData;
    }

    public function execute()
    {
        foreach ($this->rawData as $payload) {
            try {
                $existingCategory = $this->categories->getByTitle($payload['name']);
                $this->categories->update(new Category(
                    CategoryUuid::existing((string) $existingCategory->categoryUuid()),
                    $payload['name'],
                    $payload['slug']
                ));
                continue;
            } catch (CategoryNotFoundException $x) {
                $this->categories->save(Category::generated($payload['name'], $payload['slug']));
            }
        }
    }
}
