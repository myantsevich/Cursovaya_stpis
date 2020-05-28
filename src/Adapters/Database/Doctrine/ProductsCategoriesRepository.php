<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\Product\Category\Categories;
use BelkinDom\Store\Product\Category\Category;
use BelkinDom\Store\Product\Category\CategoryNotFoundException;
use Doctrine\Common\Persistence\ObjectManager;

final class ProductsCategoriesRepository implements Categories
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $title
     *
     * @return Category
     *
     * @throws CategoryNotFoundException
     */
    public function getByTitle(string $title): Category
    {
        $category = $this->objectManager->getRepository(Category::class)->findOneBy(['title' => $title]);

        if (!$category instanceof Category) {
            throw new CategoryNotFoundException($title);
        }

        return $category;
    }

    /**
     * @param string $slug
     *
     * @return Category
     *
     * @throws CategoryNotFoundException
     */
    public function getBySlug(string $slug): Category
    {
        $category = $this->objectManager->getRepository(Category::class)->findOneBy(['slug' => $slug]);

        if (!$category instanceof Category) {
            throw new CategoryNotFoundException($slug);
        }

        return $category;
    }

    /**
     * @return array
     */
    public function list(): array
    {
        return $this->objectManager->getRepository(Category::class)->findAll();
    }

    /**
     * @param Category $category
     */
    public function save(Category $category)
    {
        $this->objectManager->persist($category);
        $this->objectManager->flush();
    }

    /**
     * @param Category $category
     */
    public function update(Category $category)
    {
        $this->objectManager->merge($category);
        $this->objectManager->flush();
    }
}
