<?php

namespace AHT\Blog\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \AHT\Blog\Model\Post
     */
    protected $blogPost;

    /**
     * Constructor
     *
     * @param \AHT\Blog\Model\Post $blogPost
     */
    public function __construct(\AHT\Blog\Model\Post $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->blogPost->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

