<?php

namespace AHT\Blog\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use AHT\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('aht_blog_post_entity', 'entity_id');
    }

    protected function _afterLoad(AbstractModel $post)
    {
        $post->setCategoryIds($this->getCategoryIds($post));

        return parent::_afterLoad($post);
    }

    private function getCategoryIds(PostInterface $model)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('aht_blog_category_post'),
            'category_id'
        )->where(
            'post_id = ?',
            (int)$model->getId()
        );

        return $connection->fetchCol($select);
    }

    protected function _afterSave(AbstractModel $post)
    {
        if (isset($post['category_id'])) {
            $post['category_id'] = explode(',', $post['category_id']);
        }

        /** @var PostInterface $post */
        $this->saveCategoryIds($post);

        return parent::_afterSave($post);
    }

    /**
     * @param \AHT\BLog\Model\Post $model
     *
     * @return $this
     */
    private function saveCategoryIds(\AHT\BLog\Model\Post $model)
    {
        $connection = $this->getConnection();

        $table = $this->getTable('aht_blog_category_post');

        // create bien to get categoryId and display

        if (!$model->getCategoryIds()) {
            return $this;
        }

        $categoryIds = $model->getCategoryIds();
        $oldCategoryIds = $this->getCategoryIds($model);

        $insert = array_diff($categoryIds, $oldCategoryIds);
        $delete = array_diff($oldCategoryIds, $categoryIds);

        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $categoryId) {
                if (empty($categoryId)) {
                    continue;
                }

                $data[] = [
                    'category_id' => (int)$categoryId,
                    'post_id' => (int)$model->getId(),
                ];
            }

            if ($data) {
                $connection->insertMultiple($table, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $categoryId) {
                $where = ['post_id = ?' => (int)$model->getId(), 'category_id = ?' => (int)$categoryId];
                $connection->delete($table, $where);
            }
        }

        return $this;
    }
}
