<?php

namespace BelkinDom\Store\Product\Category;

interface Categories
{
    /**
     * @param string $title
     *
     * @throws CategoryNotFoundException
     *
     * @return Category
     */
    public function getByTitle(string $title): Category;
    /**
     * @param string $slug
     *
     * @throws CategoryNotFoundException
     *
     * @return Category
     */
    public function getBySlug(string $slug): Category;

    /**
     * @return Category[]
     */
    public function list(): array;

    /**
     * @param Category $category
     */
    public function save(Category $category);

    /**
     * @param Category $category
     */
    public function update(Category $category);
}
