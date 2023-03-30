<?php

namespace AHT\Blog\Api\Data;

use AHT\Blog\Model\ResourceModel\Post\Collection;

interface PostInterface
{
    const ID = 'entity_id';

    const STATUS           = 'status';
    const NAME             = 'name';
    const IMAGE             = 'image';
    const SHORT_DESC       = 'short_description';
    const DESC             = 'description';
    const TAG              = 'tag';
    const PUBLISH_DATE     = 'publish_date';
    const URL_KEY          = 'url_key';
    const AUTHOR           = 'author';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const CATEGORY_IDS = 'category_id';

    /**
     * @return int
     */
    public function getId();

    /**
     * Set product id
     *
     * @return $this
     */
    public function setId($value);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setStatus($value);

    /**
     * @return int
     */
    public function getAuthor();

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setAuthor($value);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setName($value);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setImage($value);

    /**
     * @return string
     */
    public function getShortDesc();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setShortDesc($value);

    /**
     * @return string
     */
    public function getDesc();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDesc($value);

    /**
     * @return string
     */
    public function getTag();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTag($value);

    /**
     * @return string
     */
    public function getPublishDate();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPublishDate($value);

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setUrlKey($value);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCreatedAt($value);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setUpdatedAt($value);

    /**
     * @return mixed
     */
    public function getCategoryIds();

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setCategoryIds(array $value);
}
