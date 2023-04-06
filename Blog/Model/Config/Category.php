<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\Blog\Model\Config;

/**
 * Attribute Set Options
 */

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use AHT\Blog\Model\ResourceModel\Category\CollectionFactory;

/**
 * Class Category
 * @package AHT\Blog\Model\Config
 */
class Category extends AbstractSource
{
    /**
     * @var CollectionFactory
     */
    private $category;
    private $post;

    /**
     * WidgetCategory constructor.
     *
     * @param CollectionFactory $category
     */
    public function __construct(
        CollectionFactory $category,
        \AHT\Blog\Model\ResourceModel\Post\CollectionFactory $post
    ) {
        $this->category = $category;
        $this->post = $post;
    }

    public function getAllOptions()
    {
        $collection = $this->category->create();
        $ar = [];
        foreach ($collection->getItems() as $item) {
            if ($item->getId() === '0') {
                continue;
            }
            $ar[] = ['value' => $item->getId(), 'label' => $item->getName()];
        }
        return $ar;
    }
}
