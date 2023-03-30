<?php

namespace AHT\Blog\Api\Data;

interface CategoryInterface
{

    const CATEGORY = 'Category';
    const ID = 'entity_id';

    /**
     * Get category_id
     * @return string|null
     */
    public function getCategoryId();

    /**
     * Set category_id
     * @param string $categoryId
     * @return \AHT\Blog\Category\Api\Data\CategoryInterface
     */
    public function setCategoryId($categoryId);

    /**
     * Get Category
     * @return string|null
     */
    public function getCategory();

    /**
     * Set Category
     * @param string $category
     * @return \AHT\Blog\Category\Api\Data\CategoryInterface
     */
    public function setCategory($category);
}
