<?php

namespace AHT\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    public function _afterLoad()
    {
        foreach ($this->_items as $item) {
            $item->load($item->getId());
        }

        return parent::_afterLoad();
    }

    protected function _construct()
    {
        $this->_init('AHT\Blog\Model\Post', 'AHT\Blog\Model\ResourceModel\Post');
    }

    public function loadPostByCategory($id)
    {
        // get data for table
        $this->blog_table = $this->getTable('aht_blog_category_post');
        $this->getSelect()
            ->join(
                $this->blog_table,
                'main_table.entity_id = ' . $this->blog_table . '.post_id',
                ['category_id']
            )
            ->where(
                $this->blog_table . '.category_id IN (?)',
                $id
            );
        return $this;
    }
}
