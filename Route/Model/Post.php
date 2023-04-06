<?php

namespace AHT\Route\Model;

use AHT\Route\Api\Data\PostInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface
{
    const CACHE_TAG = 'aht_route_post';

    protected $_cacheTag = 'aht_route_post';

    protected $_eventPrefix = 'aht_route_post';

    protected function _construct()
    {
//        echo '12345';
//        die();
        $this->_init('AHT\Route\Model\ResourceModel\Post');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }

    /**
     * @getPostId
     */
    public function getPostId()
    {
        return $this->getData('post_id');

    }
    /**
     * @setPostId
     */
    public function setPostId($postId)
    {
      return $this->setData('post_id',$postId);
    }
    /**
     * @getPostName
     */
    public function getPostName()
    {
        return $this->getData('name');
    }
    /**
     * @setPostName
     */
    public function setPostName($postName)
    {
        return $this->setData('name',$postName);
    }
    /**
     * @getPostUrl
     */
    public function getPostUrl()
    {
        return $this->getData('url_key');
    }
    /**
     * @setPostUrl
     */
    public function setPostUrl($postUrl)
    {
        return $this->setData('url_key',$postUrl);
    }
    /**
     * @getPostTags
     */
    public function getPostTags()
    {
        return $this->getData('tags');
    }
    /**
     * @setPostTags
     */
    public function setPostTags($postTags)
    {
        return $this->setData('tags',$postTags);
    }
    /**
     * @getPostStatus
     */
    public function getPostStatus()
    {
        return $this->getData('status');
    }
    /**
     * @setPostStatus
     */
    public function setPostStatus($postStatus)
    {
        return $this->setData('status',$postStatus);
    }
    /**
     * @getPostContent
     */
    public function getPostContent()
    {
        return $this->getData('post_content');
    }
    /**
     * @setPostContent
     */

    public function setPostContent($postContent)
    {
        return $this->setData('post_content',$postContent);
    }
}
