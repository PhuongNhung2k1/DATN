<?php

namespace AHT\Blog\Model;

class Category extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('AHT\Blog\Model\ResourceModel\Category');
    }
}
