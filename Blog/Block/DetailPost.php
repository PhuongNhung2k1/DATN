<?php

namespace AHT\Blog\Block;

use AHT\Blog\Model\PostFactory;
use AHT\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class DetailPost extends Template
{
    public $postFactory;
    protected $postCollection;
    /**
     * @var Registry
     */
    public $registry;
    protected $templateProcessor;

    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,
        Registry $registry,
        CollectionFactory $postCollection,
        \Zend_Filter_Interface $templateProcessor,
        array $data = []
    ) {
        $this->postFactory = $postFactory;
        $this->registry = $registry;
        $this->postCollection = $postCollection;
        $this->templateProcessor=$templateProcessor;
        return parent::__construct($context, $data);
    }

    public function getDetailPost()
    {
//        get param form url displayed(debug)
        $postId = $this->getRequest()->getParam('post_id');
        $post = $this->postFactory->create()->load($postId);

        return $post;
    }
    public function getImageUrl($image)
    {
        return $this->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . '/media/' . $image;
    }

    //Load content from builder
    public function getDescContent($content)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //Load product by product id
        $cms = $objectManager->create('Magento\Cms\Model\Template\FilterProvider');
        return $cms->getPageFilter()->filter($content);
    }
}
