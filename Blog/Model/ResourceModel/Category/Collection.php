<?php

namespace AHT\Blog\Model\ResourceModel\Category;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('AHT\Blog\Model\Category', 'AHT\Blog\Model\ResourceModel\Category');
    }
}
