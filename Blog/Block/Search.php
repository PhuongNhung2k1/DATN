<?php

namespace AHT\Blog\Block;

use AHT\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\View\Element\Template;

class Search extends Template
{
    /**
     * @var CollectionFactory
     */
    private $postCollection;

    /**
     * Display constructor.
     * @param Template\Context $context
     * @param CollectionFactory $postCollection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $postCollection,
        array $data = []
    ) {
        $this->postCollection = $postCollection;
        parent::__construct($context, $data);
    }

    public function getSearchUrl()
    {
        return (string)($this->getRequest()->getParam('key'));
    }
}
