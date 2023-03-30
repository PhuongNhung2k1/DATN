<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AHT\Route\Api\Data;

interface PostSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Post list.
     * @return \AHT\Route\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set Post list.
     * @param \AHT\Route\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
