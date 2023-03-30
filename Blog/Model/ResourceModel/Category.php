<?php

namespace AHT\Blog\Model\ResourceModel;

class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('aht_blog_category_entity', 'entity_id');
    }
}

