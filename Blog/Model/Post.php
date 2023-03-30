<?php

namespace AHT\Blog\Model;

use AHT\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use AHT\Blog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Post extends AbstractExtensibleModel implements
    IdentityInterface,
    PostInterface
{
    protected $category;
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function __construct(
        CollectionFactory $category,
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory
    ) {
        $this->category = $category;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory);
    }

    protected function _construct() {
        $this->_init('AHT\Blog\Model\ResourceModel\Post');
    }

    public function getIdentities()
    {
        // TODO: Implement getIdentities() method.
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($value)
    {
        return $this->setData(self::ID, $value);
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function setImage($image)
    {
        return $this->setData(self::NAME, $image);
    }

    public function getShortDesc()
    {
        return $this->getData(self::SHORT_DESC);
    }

    public function setShortDesc($shortDesc)
    {
        return $this->setData(self::NAME, $shortDesc);
    }

    public function getDesc()
    {
        return $this->getData(self::DESC);
    }

    public function setDesc($desc)
    {
        return $this->setData(self::NAME, $desc);
    }

    public function getTag()
    {
        return $this->getData(self::TAG);
    }

    public function setTag($tag)
    {
        return $this->setData(self::NAME, $tag);
    }

    public function getPublishDate()
    {
        return $this->getData(self::PUBLISH_DATE);
    }

    public function setPublishDate($publishDate)
    {
        return $this->setData(self::NAME, $publishDate);
    }

    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    public function setUrlKey($urlKey)
    {
        return $this->setData(self::CREATED_AT, $urlKey);
    }

    public function getAuthor()
    {
        return $this->getData(self::AUTHOR);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::NAME, $author);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /** function to filter by name */
    public function getCategories()
    {
        $ids   = $this->getCategoryIds();
        $ids[] = 0;

        $collection = $this->category->create();
        $collection->addAttributeToSelect(['name']);
        $collection->addFieldToFilter('entity_id', array('eq' => $ids));

        return $collection;
    }

    public function getCategoryIds()
    {
        return $this->getData(self::CATEGORY_IDS);
    }

    public function setCategoryIds(array $value)
    {
        return $this->setData(self::CATEGORY_IDS, $value);
    }
}
